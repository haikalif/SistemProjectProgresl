async function loadData(query = "all") {
    let query;
    const seacrhValue = document.getElementById("search").value.trim();

    if (querytype === "string" && searchValue) {
        if (isNAN(searchValue)) {
            query = `
                query {
                    bagian(id: ${searchValue}) {
                        id
                        NavigationPrecommitController
                    }
                }
            `;
        } else {
            query = `
                query{
                bagian(nama: "${seacrhValue}"){
                     id
                     nama
                    }
                }
            `;
        }
    } else {
        query = `
            query{
                allBagian{
                    id
                    nama
                }
            }
        `;
    }
}

const res = await fetch ('/graphql',{
    method: 'POST',
    headers: {'contenct-type': 'application/json'},
    body: JSON.stringify({query})
});
const data = await res.json();
const tbody = document.getElementById('dataBagian');
tbody.innerHTML = '';

let items = [];
if (data.data.allBagian) items = data.data.allBagian;
if (data.data.BagianByNama) items = data.data.BagianByNama;
if (data.data.bagian) items = [data.data.bagian];

if (items.length === 0) {
    tbody.innerHTML = '<tr><td colspan="2">Data tidak ditemukan</td></tr>';
    return;
}
