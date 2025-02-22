document.addEventListener("DOMContentLoaded", () => {
    loadAlbums();
});

function loadAlbums() {
    fetch("server.php?albums")
    .then(response => response.json())
    .then(albums => {
        let albumsDiv = document.getElementById("albums");
        let albumSelect = document.getElementById("albumSelect");
        
        albumsDiv.innerHTML = "";
        albumSelect.innerHTML = "<option value=''>เลือกอัลบั้ม</option>";

        albums.forEach(album => {
            let div = document.createElement("div");
            div.textContent = album.name;
            div.onclick = () => loadPhotos(album.id);
            albumsDiv.appendChild(div);

            let option = document.createElement("option");
            option.value = album.id;
            option.textContent = album.name;
            albumSelect.appendChild(option);
        });
    });
}

function createAlbum() {
    let albumName = document.getElementById("albumName").value;
    fetch("server.php", {
        method: "POST",
        body: new URLSearchParams({ album_name: albumName })
    }).then(() => loadAlbums());
}

function uploadPhoto() {
    let albumId = document.getElementById("albumSelect").value;
    let fileInput = document.getElementById("photo").files[0];
    
    let formData = new FormData();
    formData.append("photo", fileInput);
    formData.append("album_id", albumId);

    fetch("server.php", { method: "POST", body: formData })
    .then(() => loadPhotos(albumId));
}

function loadPhotos(albumId) {
    fetch(`server.php?photos&album_id=${albumId}`)
    .then(response => response.json())
    .then(photos => {
        let photosDiv = document.getElementById("photos");
        photosDiv.innerHTML = "";

        photos.forEach(photo => {
            let img = document.createElement("img");
            img.src = "uploads/" + photo.file_name;
            img.onclick = () => showImage(photo.id, "uploads/" + photo.file_name);
            photosDiv.appendChild(img);
        });
    });
}

// 📌 แสดงรูปใหญ่
function showImage(photoId, src) {
    let modal = document.getElementById("imageModal");
    let modalImg = document.getElementById("modalImage");
    let deleteBtn = document.getElementById("deleteButton");

    modal.style.display = "block";
    modalImg.src = src;

    deleteBtn.onclick = () => deletePhoto(photoId);
}

// 📌 ปิดหน้าต่างแสดงรูป
function closeModal() {
    document.getElementById("imageModal").style.display = "none";
}

// 📌 ลบรูปภาพ
function deletePhoto(photoId) {
    fetch("server.php", { 
        method: "POST", 
        body: new URLSearchParams({ delete_photo_id: photoId }) 
    }).then(() => {
        closeModal();
        loadAlbums();
    });
}
