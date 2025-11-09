import './bootstrap';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

// 🔹 Inisialisasi Alpine.js (agar dropdown, navbar, dll berfungsi)
window.Alpine = Alpine;
Alpine.start();

// 🔹 Inisialisasi SweetAlert2 global
window.Swal = Swal;

// ✅ Notifikasi sukses umum
window.showSuccess = (message) => {
    Swal.fire({
        title: 'Berhasil 💖',
        text: message,
        icon: 'success',
        confirmButtonText: 'OK',
        confirmButtonColor: '#f472b6',
        background: '#fff0f5',
        color: '#d63384',
    });
};

// ✅ Notifikasi error umum
window.showError = (message) => {
    Swal.fire({
        title: 'Gagal 😢',
        text: message,
        icon: 'error',
        confirmButtonText: 'OK',
        confirmButtonColor: '#e11d48',
        background: '#fff0f5',
        color: '#c9184a',
    });
};

// ✅ Konfirmasi hapus data (dipakai di tabel transaksi)
window.confirmDelete = (formId) => {
    Swal.fire({
        title: 'Anda yakin?',
        text: 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
};
