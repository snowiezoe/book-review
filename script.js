document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 500);
        }, 5000);
    });
});

function validateBookForm() {
    const title = document.querySelector('input[name="title"]');
    const author = document.querySelector('input[name="author"]');
    const genre = document.querySelector('input[name="genre"]');
    const synopsis = document.querySelector('textarea[name="synopsis"]');
    const year = document.querySelector('input[name="year"]');
    
    if (title && title.value.trim() === '') {
        alert('❌ Judul buku harus diisi!');
        title.focus();
        return false;
    }
    
    if (author && author.value.trim() === '') {
        alert('❌ Nama penulis harus diisi!');
        author.focus();
        return false;
    }
    
    if (genre && genre.value.trim() === '') {
        alert('❌ Genre buku harus diisi!');
        genre.focus();
        return false;
    }
    
    if (synopsis && synopsis.value.trim() === '') {
        alert('❌ Sinopsis buku harus diisi!');
        synopsis.focus();
        return false;
    }
    
    if (year && year.value.trim() === '') {
        alert('❌ Tahun terbit harus diisi!');
        year.focus();
        return false;
    }
    
    if (year && parseInt(year.value) < 1000) {
        alert('❌ Tahun terbit tidak valid!');
        year.focus();
        return false;
    }
    
    return true;
}

function validateRegisterForm() {
    const name = document.querySelector('input[name="name"]');
    const email = document.querySelector('input[name="email"]');
    const password = document.querySelector('input[name="password"]');
    
    if (name && name.value.trim() === '') {
        alert('❌ Nama lengkap harus diisi!');
        name.focus();
        return false;
    }
    
    if (email && email.value.trim() === '') {
        alert('❌ Email harus diisi!');
        email.focus();
        return false;
    }
    
    if (email && !isValidEmail(email.value)) {
        alert('❌ Format email tidak valid!');
        email.focus();
        return false;
    }
    
    if (password && password.value.trim() === '') {
        alert('❌ Password harus diisi!');
        password.focus();
        return false;
    }
    
    if (password && password.value.length < 6) {
        alert('❌ Password minimal 6 karakter!');
        password.focus();
        return false;
    }
    
    return true;
}

function validateLoginForm() {
    const email = document.querySelector('input[name="email"]');
    const password = document.querySelector('input[name="password"]');
    
    if (email && email.value.trim() === '') {
        alert('❌ Email harus diisi!');
        email.focus();
        return false;
    }
    
    if (password && password.value.trim() === '') {
        alert('❌ Password harus diisi!');
        password.focus();
        return false;
    }
    
    return true;
}

function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}


function confirmDelete(bookTitle) {
    if (bookTitle) {
        return confirm('⚠️ Yakin ingin menghapus buku "' + bookTitle + '"?');
    }
    return confirm('⚠️ Yakin ingin menghapus data ini?');
}


function searchBooks() {
    const input = document.getElementById('searchInput');
    if (!input) return;
    
    const filter = input.value.toLowerCase();
    const bookCards = document.querySelectorAll('.book-card');
    let found = 0;
    
    bookCards.forEach(function(card) {
        const title = card.querySelector('h3')?.textContent?.toLowerCase() || '';
        const author = card.querySelector('.author')?.textContent?.toLowerCase() || '';
        const genre = card.querySelector('.genre')?.textContent?.toLowerCase() || '';
        
        if (title.includes(filter) || author.includes(filter) || genre.includes(filter)) {
            card.style.display = '';
            found++;
        } else {
            card.style.display = 'none';
        }
    });
    
    const emptyMessage = document.getElementById('emptySearchMessage');
    if (found === 0 && bookCards.length > 0) {
        if (!emptyMessage) {
            const container = document.querySelector('.book-grid');
            const msg = document.createElement('div');
            msg.id = 'emptySearchMessage';
            msg.className = 'empty-state';
            msg.style.gridColumn = '1 / -1';
            msg.innerHTML = '<p>📭 Tidak ada buku yang ditemukan.</p>';
            container.appendChild(msg);
        }
    } else {
        if (emptyMessage) {
            emptyMessage.remove();
        }
    }
}

function previewRating(value) {
    const stars = document.querySelectorAll('.star-preview');
    if (!stars.length) return;
    
    stars.forEach(function(star, index) {
        if (index < value) {
            star.textContent = '⭐';
            star.style.color = '#fbbf24';
        } else {
            star.textContent = '☆';
            star.style.color = '#475569';
        }
    });
}

function togglePasswordVisibility() {
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    passwordInputs.forEach(function(input) {
        const wrapper = input.closest('.form-group');
        if (wrapper) {
            const toggleBtn = wrapper.querySelector('.toggle-password');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    if (input.type === 'password') {
                        input.type = 'text';
                        toggleBtn.textContent = '🙈';
                    } else {
                        input.type = 'password';
                        toggleBtn.textContent = '👁️';
                    }
                });
            }
        }
    });
}

function previewCover(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('coverPreview');
            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function toggleDarkMode() {
    const body = document.body;
    const isDark = body.getAttribute('data-theme') === 'dark';
    
    if (isDark) {
        body.removeAttribute('data-theme');
        localStorage.setItem('theme', 'light');
    } else {
        body.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.body.setAttribute('data-theme', 'dark');
    }
});

function setupBackToTop() {
    const btn = document.getElementById('backToTop');
    if (!btn) return;
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            btn.style.display = 'flex';
        } else {
            btn.style.display = 'none';
        }
    });
    
    btn.addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 'k') {
        e.preventDefault();
        const search = document.getElementById('searchInput');
        if (search) {
            search.focus();
        }
    }
    
    if (e.key === 'Escape') {
        const search = document.getElementById('searchInput');
        if (search) {
            search.value = '';
            searchBooks();
        }
    }
});

function autoResizeTextarea(textarea) {
    if (!textarea) return;
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
}

function countCharacters(textarea, counterId, maxChars) {
    if (!textarea || !counterId) return;
    
    const counter = document.getElementById(counterId);
    const count = textarea.value.length;
    
    if (counter) {
        counter.textContent = count + '/' + (maxChars || '∞');
        if (maxChars && count > maxChars) {
            counter.style.color = '#ef4444';
        } else {
            counter.style.color = '#94a3b8';
        }
    }
}

function sortBooks(sortBy) {
    const grid = document.querySelector('.book-grid');
    if (!grid) return;
    
    const cards = Array.from(grid.querySelectorAll('.book-card'));
    
    cards.sort(function(a, b) {
        let aValue, bValue;
        
        if (sortBy === 'title') {
            aValue = a.querySelector('h3')?.textContent?.toLowerCase() || '';
            bValue = b.querySelector('h3')?.textContent?.toLowerCase() || '';
        } else if (sortBy === 'author') {
            aValue = a.querySelector('.author')?.textContent?.toLowerCase() || '';
            bValue = b.querySelector('.author')?.textContent?.toLowerCase() || '';
        } else if (sortBy === 'rating') {
            aValue = parseFloat(a.querySelector('.rating')?.textContent?.replace('⭐', '') || 0);
            bValue = parseFloat(b.querySelector('.rating')?.textContent?.replace('⭐', '') || 0);
            return bValue - aValue;
        } else if (sortBy === 'newest') {
            return 0;
        }
        
        if (aValue < bValue) return -1;
        if (aValue > bValue) return 1;
        return 0;
    });
    
    if (sortBy !== 'newest') {
        cards.forEach(function(card) {
            grid.appendChild(card);
        });
    }
}

function copyToClipboard(text) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(function() {
            showNotification('✅ Berhasil disalin!');
        }).catch(function() {
            fallbackCopy(text);
        });
    } else {
        fallbackCopy(text);
    }
}

function fallbackCopy(text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);
    showNotification('✅ Berhasil disalin!');
}

function showNotification(message) {
    const notif = document.createElement('div');
    notif.className = 'notification';
    notif.textContent = message;
    notif.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: rgba(26, 35, 53, 0.95);
        color: #fbbf24;
        padding: 15px 25px;
        border-radius: 12px;
        border: 1px solid rgba(255, 215, 0, 0.2);
        box-shadow: 0 8px 30px rgba(0,0,0,0.4);
        z-index: 9999;
        animation: slideIn 0.5s ease;
        backdrop-filter: blur(10px);
    `;
    
    document.body.appendChild(notif);
    
    setTimeout(function() {
        notif.style.transition = 'opacity 0.5s';
        notif.style.opacity = '0';
        setTimeout(function() {
            notif.remove();
        }, 500);
    }, 3000);
}

const styleSheet = document.createElement('style');
styleSheet.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease forwards;
    }
    
    .book-card {
        animation: fadeIn 0.5s ease forwards;
    }
    
    .book-card:nth-child(1) { animation-delay: 0.1s; }
    .book-card:nth-child(2) { animation-delay: 0.15s; }
    .book-card:nth-child(3) { animation-delay: 0.2s; }
    .book-card:nth-child(4) { animation-delay: 0.25s; }
    .book-card:nth-child(5) { animation-delay: 0.3s; }
    .book-card:nth-child(6) { animation-delay: 0.35s; }
    .book-card:nth-child(7) { animation-delay: 0.4s; }
    .book-card:nth-child(8) { animation-delay: 0.45s; }
    
    .stat-card {
        animation: fadeIn 0.5s ease forwards;
    }
    
    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
`;
document.head.appendChild(styleSheet);

document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 500);
        }, 5000);
    });
    
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', searchBooks);
    }
    
    setupBackToTop();
    
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(function(textarea) {
        textarea.addEventListener('input', function() {
            autoResizeTextarea(this);
        });
    });
    
    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (this.querySelector('input[name="email"]') && 
                this.querySelector('input[name="password"]') && 
                !this.querySelector('input[name="name"]')) {
                if (!validateLoginForm()) {
                    e.preventDefault();
                }
            }
            
            if (this.querySelector('input[name="name"]') && 
                this.querySelector('input[name="email"]') && 
                this.querySelector('input[name="password"]')) {
                if (!validateRegisterForm()) {
                    e.preventDefault();
                }
            }
            
            if (this.querySelector('input[name="title"]') && 
                this.querySelector('input[name="author"]')) {
                if (!validateBookForm()) {
                    e.preventDefault();
                }
            }
        });
    });
    
    console.log('📚 BookVerse loaded successfully!');
});