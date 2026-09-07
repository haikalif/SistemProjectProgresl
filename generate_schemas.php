<?php

$dir = __DIR__;

$schemas = [
    'User' => [
        'model' => 'App\\Models\\User',
        'fields' => "
    id: ID!
    name: String!
    email: String!
    email_verified_at: DateTime
    created_at: DateTime
    updated_at: DateTime
    deleted_at: DateTime
    profile: UserProfile @hasOne",
        'createInput' => "
    name: String!
    email: String!
    password: String",
        'updateInput' => "
    id: ID!
    name: String
    email: String"
    ],
    'JamKerja' => [
        'model' => 'App\\Models\\ModelJamKerja',
        'fields' => "
    id: ID!
    users_profile_id: ID!
    no_wbs: String
    kode_proyek: String
    proyek_id: ID!
    aktivitas_id: ID!
    tanggal: Date!
    jumlah_jam: Float!
    keterangan: String
    status_id: ID
    mode_id: ID
    created_at: DateTime
    updated_at: DateTime
    deleted_at: DateTime
    users_profile: UserProfile @belongsTo
    proyek: Proyek @belongsTo
    aktivitas: Aktivitas @belongsTo
    status: StatusJamKerja @belongsTo
    mode: ModeJamKerja @belongsTo",
        'createInput' => "
    users_profile_id: ID!
    no_wbs: String
    kode_proyek: String
    proyek_id: ID!
    aktivitas_id: ID!
    tanggal: Date!
    jumlah_jam: Float!
    keterangan: String
    status_id: ID
    mode_id: ID",
        'updateInput' => "
    id: ID!
    users_profile_id: ID
    no_wbs: String
    kode_proyek: String
    proyek_id: ID
    aktivitas_id: ID
    tanggal: Date
    jumlah_jam: Float
    keterangan: String
    status_id: ID
    mode_id: ID"
    ],
    'JamPerTanggal' => [
        'model' => 'App\\Models\\ModelJamPerTanggal',
        'fields' => "
    id: ID!
    users_profile_id: ID!
    proyek_id: ID!
    tanggal: Date!
    jam: Float!
    created_at: DateTime
    updated_at: DateTime
    deleted_at: DateTime
    users_profile: UserProfile @belongsTo
    proyek: Proyek @belongsTo",
        'createInput' => "
    users_profile_id: ID!
    proyek_id: ID!
    tanggal: Date!
    jam: Float!",
        'updateInput' => "
    id: ID!
    users_profile_id: ID
    proyek_id: ID
    tanggal: Date
    jam: Float"
    ],
    'Lembur' => [
        'model' => 'App\\Models\\ModelLembur',
        'fields' => "
    id: ID!
    users_profile_id: ID!
    proyek_id: ID!
    tanggal: Date!
    created_at: DateTime
    updated_at: DateTime
    users_profile: UserProfile @belongsTo
    proyek: Proyek @belongsTo",
        'createInput' => "
    users_profile_id: ID!
    proyek_id: ID!
    tanggal: Date!",
        'updateInput' => "
    id: ID!
    users_profile_id: ID
    proyek_id: ID
    tanggal: Date"
    ],
    'Pesan' => [
        'model' => 'App\\Models\\ModelPesan',
        'fields' => "
    id: ID!
    pengirim: String!
    penerima: String!
    isi: String!
    parent_id: ID
    tgl_pesan: DateTime!
    jenis_id: ID
    created_at: DateTime
    updated_at: DateTime
    deleted_at: DateTime
    jenis: Jenis @belongsTo(relation: \"jenis\")
    parent: Pesan @belongsTo(relation: \"parent\")
    replies: [Pesan!] @hasMany(relation: \"replies\")",
        'createInput' => "
    pengirim: String!
    penerima: String!
    isi: String!
    parent_id: ID
    tgl_pesan: DateTime!
    jenis_id: ID",
        'updateInput' => "
    id: ID!
    pengirim: String
    penerima: String
    isi: String
    parent_id: ID
    tgl_pesan: DateTime
    jenis_id: ID"
    ],
    'Keterangan' => [
        'model' => 'App\\Models\\ModelKeterangan',
        'fields' => "
    id: ID!
    bagian_id: ID!
    proyek_id: ID!
    tanggal: Date!
    created_at: DateTime
    updated_at: DateTime
    deleted_at: DateTime
    bagian: Bagian @belongsTo
    proyek: Proyek @belongsTo",
        'createInput' => "
    bagian_id: ID!
    proyek_id: ID!
    tanggal: Date!",
        'updateInput' => "
    id: ID!
    bagian_id: ID
    proyek_id: ID
    tanggal: Date"
    ],
    'ProyekUser' => [
        'model' => 'App\\Models\\ModelProyekUser',
        'fields' => "
    id: ID!
    proyek_id: ID!
    users_profile_id: ID!
    created_at: DateTime
    updated_at: DateTime
    deleted_at: DateTime
    proyek: Proyek @belongsTo
    users_profile: UserProfile @belongsTo",
        'createInput' => "
    proyek_id: ID!
    users_profile_id: ID!",
        'updateInput' => "
    id: ID!
    proyek_id: ID
    users_profile_id: ID"
    ]
];

$imports = [];

foreach ($schemas as $name => $schema) {
    // 1. Create GraphQL schema file
    $graphqlDir = $dir . '/graphql/' . $name;
    if (!is_dir($graphqlDir)) mkdir($graphqlDir, 0777, true);
    
    $graphqlContent = <<<GQL
type {$name} {{$schema['fields']}
}

input Create{$name}Input {{$schema['createInput']}
}

input Update{$name}Input {{$schema['updateInput']}
}

extend type Query {
    all{$name}: [{$name}!]! @all(model: "{$schema['model']}") @softDeletes
    {$name}(id: ID! @eq(key: "id")): {$name} @find(model: "{$schema['model']}") @softDeletes
}

extend type Mutation {
    create{$name}(input: Create{$name}Input @spread): {$name} @create(model: "{$schema['model']}")
    update{$name}(input: Update{$name}Input @spread): {$name} @update(model: "{$schema['model']}")
    delete{$name}(id: ID! @eq(key: "id")): {$name} @delete(model: "{$schema['model']}")
    restore{$name}(id: ID! @eq(key: "id")): {$name} @field(resolver: "App\\\\GraphQL\\\\Mutations\\\\{$name}\\\\{$name}Mutations@restore")
    forceDelete{$name}(id: ID! @eq(key: "id")): {$name} @field(resolver: "App\\\\GraphQL\\\\Mutations\\\\{$name}\\\\{$name}Mutations@forceDelete")
}
GQL;
    
    // Some models don't have softDeletes (like Lembur), we should clean it up but let's just make it simple
    // Actually, Lembur doesn't have softDeletes! Let's handle it manually or let Lighthouse ignore it. 
    // It's better to remove @softDeletes and the custom restore/forceDelete for Lembur.
    if ($name === 'Lembur') {
        $graphqlContent = str_replace(['@softDeletes', 'restoreLembur', 'forceDeleteLembur', 'deleted_at'], '', $graphqlContent);
        // clean up extra lines
        $graphqlContent = preg_replace('/.*restore.*/', '', $graphqlContent);
        $graphqlContent = preg_replace('/.*forceDelete.*/', '', $graphqlContent);
    }

    file_put_contents($graphqlDir . '/schema.graphql', $graphqlContent);
    $imports[] = "#import {$name}/schema.graphql";

    // 2. Create Mutation Class
    $mutationDir = $dir . '/app/GraphQL/Mutations/' . $name;
    if (!is_dir($mutationDir)) mkdir($mutationDir, 0777, true);

    if ($name !== 'Lembur') {
        $mutationContent = <<<PHP
<?php

namespace App\GraphQL\Mutations\\{$name};

use {$schema['model']};

class {$name}Mutations
{
    public function restore(\$_, array \$args)
    {
        \$record = class_basename('{$schema['model']}') === 'User' 
            ? {$schema['model']}::withTrashed()->find(\$args['id']) 
            : {$schema['model']}::withTrashed()->find(\$args['id']);
            
        if (\$record) {
            \$record->restore();
            return \$record;
        }
    }

    public function forceDelete(\$_, array \$args)
    {
        \$record = {$schema['model']}::withTrashed()->find(\$args['id']);
        if (\$record) {
            \$record->forceDelete();
            return \$record;
        }
    }
}
PHP;
        file_put_contents($mutationDir . '/' . $name . 'Mutations.php', $mutationContent);
    }
}

// 3. Update main schema.graphql
$mainSchemaPath = $dir . '/graphql/schema.graphql';
$mainSchemaContent = file_get_contents($mainSchemaPath);
foreach ($imports as $import) {
    if (strpos($mainSchemaContent, $import) === false) {
        $mainSchemaContent .= "\n" . $import;
    }
}
file_put_contents($mainSchemaPath, $mainSchemaContent);

echo "Generation complete!";
