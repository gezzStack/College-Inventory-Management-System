function submitForm(type) {
    const formData = new FormData();

    if (type === 'computer_lab') {
        formData.append('item_name', document.getElementById('lab-item').value);
        formData.append('quantity', document.getElementById('lab-quantity').value);
        formData.append('type', 'computer_lab');
    } else if (type === 'store') {
        formData.append('item_name', document.getElementById('store-item').value);
        formData.append('quantity', document.getElementById('store-quantity').value);
        formData.append('type', 'store');
    }

    fetch('add_inventory.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        if (type === 'computer_lab') {
            document.getElementById('labForm').reset();
        } else {
            document.getElementById('storeForm').reset();
        }
    })
    .catch(error => console.error('Error:', error));
}

function showTables() {
    document.getElementById('lab-inventory').style.display = 'block';
    document.getElementById('store-inventory').style.display = 'block';

    loadInventory('computer_lab', 'computer-lab-table');
    loadInventory('store', 'store-table');
}

function loadInventory(type, tableId) {
    fetch(`get_inventory.php?type=${type}`)
    .then(response => response.json())
    .then(data => {
        const tableBody = document.querySelector(`#${tableId} tbody`);
        tableBody.innerHTML = '';

        data.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.item_name}</td>
                <td>${item.quantity}</td>
                <td>${item.last_updated}</td>
            `;
            tableBody.appendChild(row);
        });
    })
    .catch(error => console.error('Error loading inventory:', error));
}
