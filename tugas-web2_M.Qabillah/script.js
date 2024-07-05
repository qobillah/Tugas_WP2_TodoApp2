function showBorrowForm(bookId) {
    document.getElementById('bookId').value = bookId;
    document.getElementById('borrowForm').classList.remove('hidden');
}

function closeForm() {
    document.getElementById('borrowForm').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    fetch('api/books.php')
        .then(response => response.json())
        .then(data => {
            const bookList = document.getElementById('bookList');
            data.forEach(book => {
                const bookItem = document.createElement('div');
                bookItem.classList.add('book');
                bookItem.innerHTML = `
                    <h3>${book.title}</h3>
                    <p>Author: ${book.author}</p>
                    <p>Description: ${book.description}</p>
                    <button onclick="showBorrowForm(${book.id})">Borrow</button>
                `;
                bookList.appendChild(bookItem);
            });
        });
});

document.getElementById('borrowBookForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('api/borrow.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        closeForm();
        location.reload(); // Refresh page after borrowing
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
