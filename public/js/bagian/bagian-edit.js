function openEditModal(id, nama) {
    document.getElementById("editID").value = id;
    document.getElementById("editNama").value = nama;
    document.getElementById("modalEdit").classList.remove("hidden");
}

function closeEditModal() {
    document.getElementById("modalEdit").classList.add("hidden");
}

async function updateBagian() {
    const id = document.getElementById("editID").value;
    const newNama = document.getElementById("editNama").value;
    if (!newNama) return alert("nama tidak boleh kosong");

    const mutation = `
    mutation{
        updateBagianInput(input: {id: ${id}, nama: "${newNama}"}){
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
    closeEditModal();
    loadData();
}
