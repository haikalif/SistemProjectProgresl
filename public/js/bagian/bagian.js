async function loadData(action = "all") {
    let graphqlQuery;
    const searchValue = document.getElementById("search").value.trim();

    if (action === "search" && searchValue) {
        if (!isNaN(searchValue)) {
            graphqlQuery = `
                query {
                    bagian(id: ${searchValue}) {
                        id
                        nama
                    }
                }
            `;
        } else {
            graphqlQuery = `
                query {
                    BagianByNama(nama: "%${searchValue}%") {
                        id
                        nama
                    }
                }
            `;
        }
    } else {
        graphqlQuery = `
            query {
                allBagian {
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
    const tbody = document.getElementById("dataBagian");
    tbody.innerHTML = "";

    let items = [];
    if (data.errors) {
        console.error("GRAPHQL ERROR:", data.errors);
    }
    if (data?.data?.allBagian) items = data.data.allBagian;
    if (data?.data?.BagianByNama) items = data.data.BagianByNama;
    if (data?.data?.bagian) items = [data.data.bagian];

    if (items.length === 0) {
        tbody.innerHTML = '<tr><td colspan="2">Data tidak ditemukan</td></tr>';
        return;
    }

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

function searchBagian() {
    loadData("search");
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
    loadData();
}

document.addEventListener("DOMContentLoaded", () => loadData());
