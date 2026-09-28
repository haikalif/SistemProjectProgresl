async function loadData(action = "all") {
    let graphqlQuery;
    const searchElement = document.getElementById("searchLevel");
    const searchValue = searchElement ? searchElement.value.trim() : "";

    if (action === "search" && searchValue) {
        if (!isNaN(searchValue)) {
            graphqlQuery = `
                query {
                    Level(id: ${searchValue}) {
                        id
                        nama
                    }
                }
            `;
        } else {
            graphqlQuery = `
                query {
                    LevelByNama(nama: "%${searchValue}%") {
                        id
                        nama
                    }
                }
            `;
        }
    } else {
        graphqlQuery = `
            query {
                allLevel {
                    id
                    nama
                }
                allArsip {
                    id
                    nama
                }
            }
        `;
    }

    const res = await fetch("/graphql", {
        method: "POST",
        headers: { "content-type": "application/json" },
        body: JSON.stringify({ query: graphqlQuery }),
    });
    const data = await res.json();
    const tbodyAktif = document.getElementById("dataLevel");
    const tbodyArsip = document.getElementById("dataLevelArsip");
    if(tbodyAktif) tbodyAktif.innerHTML = "";
    if(tbodyArsip) tbodyArsip.innerHTML = "";

    let itemsAktif = [];
    let itemsArsip = [];
    if (data.errors) {
        console.error("GRAPHQL ERROR:", data.errors);
    }
    
    if (action === "search" && searchValue) {
        if (data?.data?.Level) itemsAktif = [data.data.Level];
        if (data?.data?.LevelByNama) itemsAktif = data.data.LevelByNama;
    } else {
        if (data?.data?.allLevel) itemsAktif = data.data.allLevel;
        if (data?.data?.allArsip) itemsArsip = data.data.allArsip;
    }

    if (itemsAktif.length === 0 && tbodyAktif) {
        tbodyAktif.innerHTML = '<tr><td colspan="3" class="p-2 text-center border">Data tidak ditemukan</td></tr>';
    } else if (tbodyAktif) {
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

    if (itemsArsip.length === 0 && tbodyArsip) {
        tbodyArsip.innerHTML = '<tr><td colspan="3" class="p-2 text-center border">Data arsip tidak ditemukan</td></tr>';
    } else if (tbodyArsip) {
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

function searchLevel() {
    loadData("search");
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
    loadData();
}

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
    loadData();
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
    loadData();
}

document.addEventListener("DOMContentLoaded", () => loadData());
