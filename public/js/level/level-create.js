function openAddLevelModal(){
    document.getElementById('modalAddLevel').classList.remove('hidden');
}

function closeAddLevelModal(){
    document.getElementById('modalAddLevel').classList.add('hidden');
    document.getElementById('addNamaLevel').value = '';
}

async function createLevel() {
    const nama = document.getElementById('addNamaLevel').value;
    if (!nama) return alert("Nama tidak boleh kosong");

    const mutation = `
        mutation{
            createLevelInput(input: {nama: "${nama}"}){
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
    closeAddLevelModal();
    loadData();
}
