function createAlbum() {
    const albumName = document.getElementById('albumName').value;
    if (albumName) {
        // Call to PHP to create album in database
        fetch('create_album.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name: albumName }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('สร้างอัลบั้มเรียบร้อย');
                document.getElementById('createAlbumModal').style.display = 'none';
                loadAlbums();
            } else {
                alert('เกิดข้อผิดพลาด: ' + data.message);
            }
        });
    } else {
        alert('กรุณากรอกชื่ออัลบั้ม');
    }
}

function loadAlbums() {
    fetch('load_albums.php')
    .then(response => response.json())
    .then(data => {
        const albumsDiv = document.getElementById('albums');
        albumsDiv.innerHTML = '';
        data.albums.forEach(album => {
            albumsDiv.innerHTML += `
                <div class="album">
                    <h3>${album.name}</h3>
                    <button onclick="openAlbum('${album.id}')">เปิด</button>
                    <button onclick="deleteAlbum('${album.id}')">ลบอัลบั้ม</button>
                </div>
            `;
        });
    });
}

// Call loadAlbums on page load
document.addEventListener('DOMContentLoaded', loadAlbums);
