import axios from "axios";

document.getElementById("checkinButton").addEventListener("click", function () {
    const nobooking = document.getElementById("nobooking").innerText;

    axios
        .post('/checkin', { nobooking: nobooking })
        .then((response) => {
            if (response.data.success) {
                alert("Check-in berhasil!");
                location.reload();
            } else {
                console.log(response);
                alert("Check-in gagal: " + response.data.message);
            }
        })
        .catch((error) => {
            alert("Terjadi kesalahan: " + error.response.data.message);
        });
});
