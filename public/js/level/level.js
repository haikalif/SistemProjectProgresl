let currentPage = 1;

async function loadDataPaginate(page = 1) {
    currentPage = page;
    const searchElement = document.getElementById("searchLevel") || document.getElementById("search");
    const searchValue = searchElement ? searchElement.value.trim() : "";
    const perPageElement = document.getElementById("perPage");
    const perPage = perPageElement ? parseInt(perPageElement.value) : 10;

    let graphqlQuery = `
        query {
            allLevelPaginate(search: "${searchValue}", first: ${perPage}, page: ${page}) {
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
            allArsip {
                id
                nama
            }
        }
    `;

    const res = await fetch("/graphql", {
        method: "POST",
        headers: { "content-type": "application/json" },
        body: JSON.stringify({ query: graphqlQuery }),
    });
    const data = await res.json();
    const tbodyAktif = document.getElementById("dataLevel");
    const tbodyArsip = document.getElementById("dataLevelArsip");
    if (tbodyAktif) tbodyAktif.innerHTML = "";
    if (tbodyArsip) tbodyArsip.innerHTML = "";

    if (data.errors) {
        console.error("GRAPHQL ERROR:", data.errors);
        // Fallback if PaginatorInfo is somehow wrong case
        if (data.errors[0]?.message?.includes("Cannot query field")) {
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
    const tbodyAktif = document.getElementById("dataLevel");
    const tbodyArsip = document.getElementById("dataLevelArsip");

    const result = data?.data?.allLevelPaginate;
    const itemsAktif = result?.data || [];
    const info = result?.PaginatorInfo || result?.paginatorInfo;
    const itemsArsip = data?.data?.allArsip || [];

    // Render Data Aktif
    if (itemsAktif.length === 0) {
        if (tbodyAktif) {
            tbodyAktif.innerHTML = '<tr><td colspan="3" class="text-center p-2">Data tidak ditemukan</td></tr>';
        }

        const pageInfoElement = document.getElementById("pageInfo");
        if (pageInfoElement) pageInfoElement.innerText = "";

        const prevBtn = document.getElementById("prevBtn");
        if (prevBtn) prevBtn.disabled = true;

        const nextBtn = document.getElementById("nextBtn");
        if (nextBtn) nextBtn.disabled = true;
    } else {
        if (tbodyAktif) {
            itemsAktif.forEach((item) => {
                if (!item) return;
                tbodyAktif.innerHTML += `
                <tr>
                    <td class="border p-2 text-center">${item.id}</td>
                    <td class="border p-2">${item.nama}</td>
                    <td class="border p-2 flex gap-1 justify-center">
                        <button onclick="openEditLevelModal(${item.id}, '${item.nama}')" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                        <button onclick="hapusLevel(${item.id})" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    </td>
                </tr>
                `;
            });
        }

        if (info) {
            const pageInfoElement = document.getElementById("pageInfo");
            if (pageInfoElement) {
                pageInfoElement.innerText = `Halaman ${info.currentPage} dari ${info.lastPage} (Total: ${info.total})`;
            }

            const prevBtn = document.getElementById("prevBtn");
            if (prevBtn) prevBtn.disabled = info.currentPage <= 1;

            const nextBtn = document.getElementById("nextBtn");
            if (nextBtn) nextBtn.disabled = !info.hasMorePages;
        }
    }

    // Render Data Arsip
    if (tbodyArsip) {
        if (itemsArsip.length === 0) {
            tbodyArsip.innerHTML = '<tr><td colspan="3" class="p-2 text-center border">Data arsip tidak ditemukan</td></tr>';
        } else {
            itemsArsip.forEach((item) => {
                if (!item) return;
                tbodyArsip.innerHTML += `
                <tr>
                    <td class="border p-2 text-center">${item.id}</td>
                    <td class="border p-2">${item.nama}</td>
                    <td class="border p-2 flex gap-1 justify-center">
                        <button onclick="restoreLevel(${item.id})" class="bg-green-500 text-white px-2 py-1 rounded">Restore</button>
                        <button onclick="forceHapusLevel(${item.id})" class="bg-red-700 text-white px-2 py-1 rounded">Hapus Permanen</button>
                    </td>
                </tr>
                `;
            });
        }
    }
}

// Wrapper for backward compatibility with create/edit files that call loadData()
async function loadData() {
    await loadDataPaginate(currentPage);
}

function searchLevel() {
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

async function hapusLevel(id) {
    if (!confirm("Yakin ingin mengarsipkan data ini?")) return;
    const mutation = `
        mutation{
            deleteLevel(id: ${id}){
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

// Alias for archiveLevel if referenced
const archiveLevel = hapusLevel;

async function restoreLevel(id) {
    if (!confirm("Yakin ingin mengembalikan data ini?")) return;
    const mutation = `
        mutation{
            restoreLevel(id: ${id}){
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

async function forceHapusLevel(id) {
    if (!confirm("Yakin ingin menghapus permanen data ini?")) return;
    const mutation = `
        mutation{
            forceDeleteLevel(id: ${id}){
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

// Alias for forceDeleteLevel if referenced
const forceDeleteLevel = forceHapusLevel;

document.addEventListener("DOMContentLoaded", () => loadDataPaginate(1));
