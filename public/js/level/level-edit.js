function openEditLevelModal(id, nama) {
    document.getElementById("editIDLevel").value = id;
    document.getElementById("editNamaLevel").value = nama;
    document.getElementById("modalEditLevel").classList.remove("hidden");
}

function closeEditLevelModal() {
    document.getElementById("modalEditLevel").classList.add("hidden");
}

async function updateLevel() {
    const id = document.getElementById("editIDLevel").value;
    const newNama = document.getElementById("editNamaLevel").value;
    if (!newNama) return alert("Nama tidak boleh kosong");

    const mutation = `
    mutation{
        updateLevelInput(input: {id: ${id}, nama: "${newNama}"}){
            id
            nama
            }
        }
      `;

    await fetch("/graphql", {
        method: "POST",
        headers: { "content-type": "application/json" },
        body: JSON.stringify({ query: mutation }),
    });
    closeEditLevelModal();
    loadData();
}
