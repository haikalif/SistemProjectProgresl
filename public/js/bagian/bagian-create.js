function openAddModal(){
    document.getElementById('modalAdd').classList.remove('hidden');
}

function closeAddModal(){
    document.getElementById('modalAdd').classList.add('hidden');
    document.getElementById('addNama').value = '';
}

async function createBagian() {
    const nama = document.getElementById('addNama').value;
    if (!nama) return alert("nama tidak boleh kosong");

    const mutation = `
        mutation{
            createBagianInput(input: {nama: "${nama}"}){
                id
                nama
            }
        }
    `;
    await fetch ('/graphql',{
        method: 'POST',
        headers: {'content-type': 'application/json'},
        body: JSON.stringify({query : mutation})
    });
    closeAddModal();
    loadData();
}
