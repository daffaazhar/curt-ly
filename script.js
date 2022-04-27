// Menyimpan element yang dibutuhkan pada variabel
const form = document.querySelector(".wrapper form");
const fullUrl = form.querySelector("input");
const shortenBtn = form.querySelector("form button");
const blurEffect = document.querySelector(".blur-effect");
const popupBox = document.querySelector(".popup-box");
const infoBox = popupBox.querySelector(".info-box");
const formPopup = popupBox.querySelector("form");
const shortenUrl = popupBox.querySelector("form .shorten-url");
const copyBtn = popupBox.querySelector("form .copy-icon");
const saveBtn = popupBox.querySelector("button");

// Fungsi yang mencegah form dikirimkan
form.onsubmit = (e) => {
  e.preventDefault();
};

// Fungsi yang dilakukan ketika tombol "Shorten" di-klik
shortenBtn.onclick = () => {
  // AJAX request
  let xhr = new XMLHttpRequest(); // Membuat objek XHR
  xhr.open("POST", "php/url-control.php", true);
  xhr.onload = () => {
    if (xhr.status === 200 && xhr.readyState === 4) {
      // Melakukan pengecekan apakah AJAX request berhasil
      let data = xhr.response;
      if (data.length <= 5) {
        blurEffect.style.display = "block";
        popupBox.classList.add("show");

        let domain = "localhost/url-shortener/";
        shortenUrl.value = domain + data;

        copyBtn.onclick = () => {
          shortenUrl.select();
          document.execCommand("copy");
        };

        saveBtn.onclick = () => {
          formPopup.onsubmit = (e) => {
            e.preventDefault();
          };

          let xhr2 = new XMLHttpRequest(); // Membuat objek XHR
          xhr2.open("POST", "php/edit-url.php", true);
          xhr2.onload = () => {
            if (xhr2.status === 200 && xhr2.readyState === 4) {
              let data = xhr2.response;
              if (data == "success") {
                location.reload();
              } else {
                infoBox.classList.add("error");
                infoBox.innerText = data;
              }
            }
          };

          // Mengirim 2 data dari AJAX ke file php
          let shorten_url = shortenUrl.value;
          let hidden_url = data;
          xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhr2.send(`shorten_url=${shorten_url}&hidden_url=${hidden_url}`);
        };
      } else {
        alert(data);
      }
    }
  };

  let formData = new FormData(form); // Membuat objek FormData baru
  xhr.send(formData); // Mengirim data form ke file PHP
};
