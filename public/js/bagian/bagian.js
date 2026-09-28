let currentPage = 1;

async function loadDataPaginate(page = 1) {
    currentPage = page;
    const searchElement = document.getElementById("search");
    const searchValue = searchElement ? searchElement.value.trim() : "";
    const perPageElement = document.getElementById("perPage");
    const perPage = perPageElement ? parseInt(perPageElement.value) : 10;

    let graphqlQuery = `
        query {
            allBagianPaginate(search: "${searchValue}", first: ${perPage}, page: ${page}) {
                data {
                    id
                    nama
                }
                PaginatorInfo {
                    currentPage
                    lastPage
                    hasMorePages
                    total
                }
            }
        }
    `;

    const res = await fetch("/graphql", {
        method: "POST",
        headers: { "content-type": "application/json" },
        body: JSON.stringify({ query: graphqlQuery }),
    });
    const data = await res.json();
    const tbody = document.getElementById("dataBagian");
    if (tbody) tbody.innerHTML = "";

    if (data.errors) {
        console.error("GRAPHQL ERROR:", data.errors);
        // Fallback if PaginatorInfo is somehow wrong case
        if (data.errors[0].message.includes("Cannot query field")) {
             graphqlQuery = graphqlQuery.replace("PaginatorInfo", "paginatorInfo");
             const resRetry = await fetch("/graphql", {
                 method: "POST",
                 headers: { "content-type": "application/json" },
                 body: JSON.stringify({ query: graphqlQuery }),
             });
             const dataRetry = await resRetry.json();
             handleData(dataRetry);
             return;
        }
    }

    handleData(data);
}

function handleData(data) {
    const tbody = document.getElementById("dataBagian");
    
    const result = data?.data?.allBagianPaginate;
    const items = result?.data || [];
    const info = result?.PaginatorInfo || result?.paginatorInfo;

    if (items.length === 0) {
        if (tbody) tbody.innerHTML = '<tr><td colspan="3" class="text-center p-2">Data tidak ditemukan</td></tr>';
        
        const pageInfoElement = document.getElementById("pageInfo");
        if (pageInfoElement) pageInfoElement.innerText = "";
        
        const prevBtn = document.getElementById("prevBtn");
        if (prevBtn) prevBtn.disabled = true;
        
        const nextBtn = document.getElementById("nextBtn");
        if (nextBtn) nextBtn.disabled = true;
        
        return;
    }

    if (tbody) {
        items.forEach((item) => {
            if (!item) return;
            tbody.innerHTML += `
            <tr>
              <td class="border p-2">${item.id}</td>
              <td class="border p-2">${item.nama}</td>
              <td class="border p-2 flex gap-1">
                <button onclick="openEditModal(${item.id}, '${item.nama}')" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                <button onclick="hapusBagian(${item.id})" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
              </td>
            </tr>
            `;
        });
    }

    if (info) {
        const pageInfoElement = document.getElementById("pageInfo");
        if (pageInfoElement) pageInfoElement.innerText = `Halaman ${info.currentPage} dari ${info.lastPage} (Total: ${info.total})`;
        
        const prevBtn = document.getElementById("prevBtn");
        if (prevBtn) prevBtn.disabled = info.currentPage <= 1;
        
        const nextBtn = document.getElementById("nextBtn");
        if (nextBtn) nextBtn.disabled = !info.hasMorePages;
    }
}

// Wrapper for backward compatibility with create/edit files that might call loadData()
async function loadData() {
    await loadDataPaginate(currentPage);
}

function searchBagian() {
    loadDataPaginate(1);
}

function prevPage() {
    if (currentPage > 1) {
        loadDataPaginate(currentPage - 1);
    }
}

function nextPage() {
    loadDataPaginate(currentPage + 1);
}

async function hapusBagian(id) {
    if (!confirm("yakin ingin menghapus ini?")) return;
    const mutation = `
        mutation{
         deleteBagian(id: ${id}){
         id
         }
        }
    `;
    await fetch("/graphql", {
        method: "POST",
        headers: { "content-type": "application/json" },
        body: JSON.stringify({ query: mutation }),
    });
    loadDataPaginate(currentPage);
}

document.addEventListener("DOMContentLoaded", () => loadDataPaginate(1));
