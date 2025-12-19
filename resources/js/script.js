document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const navMenu = document.getElementById('navMenu');

    // Menambah/menghapus kelas 'active' pada klik tombol toggle
    menuToggle.addEventListener('click', function() {
        navMenu.classList.toggle('active');
        
        // Mengubah ikon hamburger (fa-bars) menjadi ikon silang (fa-times)
        const icon = menuToggle.querySelector('i');
        if (navMenu.classList.contains('active')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });

    // Opsional: Tutup menu saat salah satu link diklik (berguna di tampilan mobile)
    const navItems = navMenu.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.addEventListener('click', function() {
            // Hanya berlaku jika lebar layar kurang dari 768px (seperti di CSS)
            if (window.innerWidth <= 768) { 
                navMenu.classList.remove('active');
                
                // Kembalikan ikon menjadi hamburger
                const icon = menuToggle.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    });
});
const wavePath = document.querySelector('.wave-footer path'); let increment = 0; function animateWave() { increment += 0.003; const d = `M0,192L48,${197 + Math.sin(increment) * 20}C96,203,192,213,288,${229 + Math.sin(increment + 0.5) * 20}C384,245,480,267,576,${250 + Math.sin(increment + 1) * 20}C672,235,768,181,864,${181 + Math.sin(increment + 1.5) * 20}C960,181,1056,235,1152,${234 + Math.sin(increment + 2) * 20}C1248,235,1344,181,1392,${154 + Math.sin(increment + 2.5) * 20}L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z`; wavePath.setAttribute('d', d); requestAnimationFrame(animateWave); } animateWave();
import { GoogleGenAI } from "@google/genai";

// The client gets the API key from the environment variable `GEMINI_API_KEY`.
const ai = new GoogleGenAI({});

async function main() {
  const response = await ai.models.generateContent({
    model: "gemini-2.5-flash",
    contents: "Explain how AI works in a few words",
  });
  console.log(response.text);
}

main();