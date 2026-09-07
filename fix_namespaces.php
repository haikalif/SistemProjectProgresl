<?php

$baseDir = __DIR__;
$mutationsDir = $baseDir . '/app/GraphQL/Mutations';
$graphqlDir = $baseDir . '/graphql';

// 1. Standardize all folders and files in app/GraphQL/Mutations
$iterator = new DirectoryIterator($mutationsDir);
foreach ($iterator as $fileinfo) {
    if ($fileinfo->isDot()) continue;
    if ($fileinfo->isDir()) {
        $oldFolder = $fileinfo->getFilename();
        
        // Convert to PascalCase (e.g. mode_jam_kerja -> ModeJamKerja, jenis -> Jenis)
        $pascalFolder = str_replace(' ', '', ucwords(str_replace('_', ' ', $oldFolder)));
        
        $oldPath = $fileinfo->getPathname();
        $newPath = $mutationsDir . '/' . $pascalFolder;
        
        // Rename folder if different
        if ($oldFolder !== $pascalFolder) {
            rename($oldPath, $newPath);
            echo "Renamed folder: $oldFolder -> $pascalFolder\n";
        }
        
        // Now handle the file inside
        $filesInside = glob($newPath . '/*.php');
        foreach ($filesInside as $file) {
            $oldFilename = basename($file);
            $expectedFilename = $pascalFolder . 'Mutations.php';
            
            if ($oldFilename !== $expectedFilename) {
                $newFilePath = $newPath . '/' . $expectedFilename;
                rename($file, $newFilePath);
                echo "Renamed file: $oldFilename -> $expectedFilename\n";
                $file = $newFilePath; // update for next step
            }
            
            // Fix namespace and class name inside the file
            $content = file_get_contents($file);
            $content = preg_replace('/namespace App\\\\GraphQL\\\\Mutations\\\\[a-zA-Z0-9_]+;/', "namespace App\\GraphQL\\Mutations\\$pascalFolder;", $content);
            $content = preg_replace('/class [a-zA-Z0-9_]+/', "class {$pascalFolder}Mutations", $content);
            file_put_contents($file, $content);
        }
    }
}

// 2. Standardize all resolvers in graphql/**/*.graphql
$schemaIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($graphqlDir));
foreach ($schemaIterator as $fileinfo) {
    if ($fileinfo->isFile() && $fileinfo->getExtension() === 'graphql') {
        $file = $fileinfo->getPathname();
        $content = file_get_contents($file);
        
        $modified = false;
        // Find resolver strings: resolver: "App\\GraphQL\\Mutations\\...\\...@..."
        $content = preg_replace_callback('/resolver:\s*"App\\\\\\\\GraphQL\\\\\\\\Mutations\\\\\\\\([a-zA-Z0-9_]+)\\\\\\\\([a-zA-Z0-9_]+)@(restore|forceDelete)"/', function($matches) {
            $folder = $matches[1];
            $pascalFolder = str_replace(' ', '', ucwords(str_replace('_', ' ', $folder)));
            $expectedClass = $pascalFolder . 'Mutations';
            $method = $matches[3];
            
            return 'resolver: "App\\\\GraphQL\\\\Mutations\\\\'.$pascalFolder.'\\\\'.$expectedClass.'@'.$method.'"';
        }, $content, -1, $count);
        
        // Also check if resolver is empty or split on multiple lines (like in ModeJamKerja schema previously?)
        // In grep we saw: "resolver:" alone on a line for ModeJamKerja. Let's fix that if it exists.
        $content = preg_replace_callback('/restore([a-zA-Z0-9_]+)\(id: ID! @eq\(key: "id"\)\): \1\s*@field\(\s*resolver:\s*"?"?\s*\)/', function($matches) {
            $model = $matches[1];
            return 'restore'.$model.'(id: ID! @eq(key: "id")): '.$model.' @field(resolver: "App\\\\GraphQL\\\\Mutations\\\\'.$model.'\\\\'.$model.'Mutations@restore")';
        }, $content);
        
        $content = preg_replace_callback('/forceDelete([a-zA-Z0-9_]+)\(id: ID! @eq\(key: "id"\)\): \1\s*@field\(\s*resolver:\s*"?"?\s*\)/', function($matches) {
            $model = $matches[1];
            return 'forceDelete'.$model.'(id: ID! @eq(key: "id")): '.$model.' @field(resolver: "App\\\\GraphQL\\\\Mutations\\\\'.$model.'\\\\'.$model.'Mutations@forceDelete")';
        }, $content);
        
        if ($content !== file_get_contents($file)) {
            file_put_contents($file, $content);
            echo "Updated resolvers in: " . basename($file) . "\n";
        }
    }
}

echo "All schema namespaces and folders standardized.\n";
