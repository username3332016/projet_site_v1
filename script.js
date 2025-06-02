// JavaScript source code
// État global de l'application
let currentUser = null;
let isAuthMode = 'login'; // 'login' ou 'register'
let authStep = 1;
let cart = [];
let products = [];

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function () {
    initializeApp();
});

// Fonction d'initialisation
function initializeApp() {
    loadProducts();
    loadUserSession();
    displayProducts();
    updateCartDisplay();
    updateAuthUI();

    // Gestion du formulaire d'authentification
    document.getElementById('auth-form').addEventListener('submit', handleAuthSubmit);
}

// Gestion des sections
function showSection(sectionId) {
    // Masquer toutes les sections
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => section.classList.remove('active'));

    // Afficher la section demandée
    const targetSection = document.getElementById(sectionId);
    if (targetSection) {
        targetSection.classList.add('active');
    }

    // Logique spécifique selon la section
    switch (sectionId) {
        case 'profile':
            if (!currentUser) {
                showSection('auth');
                return;
            }
            updateProfileDisplay();
            break;
        case 'progress':
            if (!currentUser) {
                showSection('auth');
                return;
            }
            updateProgressDisplay();
            break;
        case 'admin':
            if (!currentUser || currentUser.email !== 'admin@fitlife.com') {
                alert('Accès non autorisé');
                showSection('home');
                return;
            }
            break;
    }
}

// Gestion des produits
function loadProducts() {
    products = [
        // Produits de Sport
        {
            id: 1,
            name: "Kit Haltères Ajustables",
            category: "Produits de Sport",
            price: 129.99,
            description: "Set complet d'haltères ajustables 5-25kg"
        },
        {
            id: 2,
            name: "Tapis de Yoga Premium",
            category: "Produits de Sport",
            price: 49.99,
            description: "Tapis antidérapant en matière écologique"
        },
        {
            id: 3,
            name: "Bandes de Résistance",
            category: "Produits de Sport",
            price: 24.99,
            description: "Kit de 5 bandes avec ancrage de porte"
        },
        {
            id: 4,
            name: "Kettlebell 16kg",
            category: "Produits de Sport",
            price: 39.99,
            description: "Kettlebell en fonte avec poignée ergonomique"
        },

        // Gummies Compléments
        {
            id: 5,
            name: "Gummies Multivitamines",
            category: "Gummies Compléments",
            price: 19.99,
            description: "30 gummies aux fruits rouges, vitamines A-Z"
        },
        {
            id: 6,
            name: "Gummies Oméga-3",
            category: "Gummies Compléments",
            price: 24.99,
            description: "Acides gras essentiels, goût citron"
        },
        {
            id: 7,
            name: "Gummies Sommeil",
            category: "Gummies Compléments",
            price: 22.99,
            description: "Mélatonine naturelle, saveur lavande"
        },
        {
            id: 8,
            name: "Gummies Énergie",
            category: "Gummies Compléments",
            price: 21.99,
            description: "Vitamine B12 et ginseng, goût tropical"
        },

        // Boxes Culinaires
        {
            id: 9,
            name: "Box Détox 7 jours",
            category: "Boxes Culinaires Saines",
            price: 89.99,
            description: "21 repas équilibrés pour purifier l'organisme"
        },
        {
            id: 10,
            name: "Box Protéinée",
            category: "Boxes Culinaires Saines",
            price: 79.99,
            description: "Repas riches en protéines pour sportifs"
        },
        {
            id: 11,
            name: "Box Végétarienne",
            category: "Boxes Culinaires Saines",
            price: 69.99,
            description: "Cuisine plant-based gourmande et nutritive"
        },
        {
            id: 12,
            name: "Box Minceur",
            category: "Boxes Culinaires Saines",
            price: 74.99,
            description: "Repas hypocaloriques savoureux"
        },

        // Coaching
        {
            id: 13,
            name: "Coaching Débutant",
            category: "Coaching Personnalisé",
            price: 99.99,
            description: "Programme 4 semaines avec coach dédié"
        },
        {
            id: 14,
            name: "Coaching Avancé",
            category: "Coaching Personnalisé",
            price: 149.99,
            description: "Suivi personnalisé 8 semaines"
        },
        {
            id: 15,
            name: "Coaching Nutrition",
            category: "Coaching Personnalisé",
            price: 79.99,
            description: "Plan alimentaire sur mesure avec suivi"
        },
        {
            id: 16,
            name: "Coaching Complet",
            category: "Coaching Personnalisé",
            price: 199.99,
            description: "Sport + nutrition + bien-être 12 semaines"
        }
    ];
}

// Affichage des produits
function displayProducts(filteredProducts = null) {
    const container = document.getElementById('products-container');
    const productsToShow = filteredProducts || products;

    container.innerHTML = '';

    productsToShow.forEach(product => {
        const productCard = createProductCard(product);
        container.appendChild(productCard);
    });
}

// Création d'une carte produit
function createProductCard(product) {
    const card = document.createElement('div');
    card.className = 'product-card';
    card.innerHTML = `
        <div class="product-img">
            ${getProductIcon(product.category)}
        </div>
        <div class="product-content">
            <h3>${product.name}</h3>
            <p>${product.description}</p>
            <div class="product-price">${product.price.toFixed(2)}€</div>
            <button class="btn btn-primary btn-full" onclick="addToCart(${product.id})">
                Ajouter au panier
            </button>
        </div>
    `;
    return card;
}

// Icônes pour les catégories
function getProductIcon(category) {
    const icons = {
        'Produits de Sport': '🏋️',
        'Gummies Compléments': '🍯',
        'Boxes Culinaires Saines': '🥗',
        'Coaching Personnalisé': '👨‍💼'
    };
    return icons[category] || '📦';
}

// Filtrage des produits
function filterProducts(category) {
    // Mise à jour des boutons de filtre
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');

    // Filtrage
    let filteredProducts = products;
    if (category !== 'all') {
        filteredProducts = products.filter(product => product.category === category);
    }

    displayProducts(filteredProducts);
}

// Gestion du panier
function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    if (!product) return;

    const existingItem = cart.find(item => item.id === productId);
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({
            ...product,
            quantity: 1
        });
    }

    updateCartDisplay();
    showCartNotification(product.name);
}

// Notification d'ajout au panier
function showCartNotification(productName) {
    // Création d'une notification simple
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: #34c759;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        z-index: 10000;
        transition: all 0.3s ease;
    `;
    notification.textContent = `${productName} ajouté au panier`;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => document.body.removeChild(notification), 300);
    }, 2000);
}

// Mise à jour de l'affichage du panier
function updateCartDisplay() {
    const cartCount = document.getElementById('cart-count');
    const cartItems = document.getElementById('cart-items');
    const cartSummary = document.getElementById('cart-summary');
    const cartTotal = document.getElementById('cart-total');

    // Compteur panier
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCount.textContent = totalItems;
    cartCount.style.display = totalItems > 0 ? 'block' : 'none';

    // Contenu du panier
    if (cart.length === 0) {
        cartItems.innerHTML = `
            <div class="empty-state">
                <i class="fa fa-shopping-cart"></i>
                <p>Votre panier est vide</p>
            </div>
        `;
        cartSummary.style.display = 'none';
    } else {
        cartItems.innerHTML = cart.map(item => `
            <div class="cart-item">
                <div class="cart-item-info">
                    <h4>${item.name}</h4>
                    <p>Quantité: ${item.quantity}</p>
                </div>
                <div class="cart-item-actions">
                    <span style="font-weight: 600; font-size: 1.1rem;">
                        ${(item.price * item.quantity).toFixed(2)}€
                    </span>
                    <button onclick="removeFromCart(${item.id})" style="margin-left: 10px; background: #ff3b30; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        `).join('');

        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        cartTotal.textContent = `Total: ${total.toFixed(2)}€`;
        cartSummary.style.display = 'block';
    }
}

// Supprimer du panier
function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    updateCartDisplay();
}

// Commande
function checkout() {
    if (!currentUser) {
        alert('Veuillez vous connecter pour commander');
        showSection('auth');
        return;
    }

    if (cart.length === 0) {
        alert('Votre panier est vide');
        return;
    }

    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    alert(`Commande validée !\nTotal: ${total.toFixed(2)}€\nMerci ${currentUser.prenom} !`);

    cart = [];
    updateCartDisplay();
    showSection('home');
}

// Gestion de l'authentification
function toggleAuth() {
    if (currentUser) {
        logout();
    } else {
        showSection('auth');
    }
}

function switchAuthMode() {
    isAuthMode = isAuthMode === 'login' ? 'register' : 'login';
    authStep = 1;
    updateAuthUI();
}

function updateAuthUI() {
    const authBtn = document.getElementById('auth-btn');
    const adminBtn = document.getElementById('admin-btn');
    const authTitle = document.getElementById('auth-title');
    const authSubtitle = document.getElementById('auth-subtitle');
    const switchText = document.getElementById('switch-text');
    const switchLink = document.getElementById('switch-link');

    if (currentUser) {
        authBtn.textContent = 'Déconnexion';
        authBtn.className = 'btn btn-secondary';

        if (currentUser.email === 'admin@fitlife.com') {
            adminBtn.style.display = 'inline-block';
        }
    } else {
        authBtn.textContent = 'Connexion';
        authBtn.className = 'btn btn-primary';
        adminBtn.style.display = 'none';
    }

    // Interface d'authentification
    if (isAuthMode === 'login') {
        authTitle.textContent = 'Connexion';
        authSubtitle.textContent = 'Accédez à votre espace personnel';
        switchText.textContent = 'Pas encore de compte ?';
        switchLink.textContent = 'S\'inscrire';

        document.getElementById('nom-group').style.display = 'none';
        document.getElementById('prenom-group').style.display = 'none';
        document.getElementById('next-step-btn').style.display = 'none';
        document.getElementById('login-btn').style.display = 'block';
    } else {
        authTitle.textContent = 'Inscription';
        authSubtitle.textContent = 'Créez votre compte FitLife';
        switchText.textContent = 'Déjà un compte ?';
        switchLink.textContent = 'Se connecter';

        document.getElementById('nom-group').style.display = 'block';
        document.getElementById('prenom-group').style.display = 'block';
        document.getElementById('next-step-btn').style.display = 'block';
        document.getElementById('login-btn').style.display = 'none';
    }

    updateAuthSteps();
}

function updateAuthSteps() {
    const steps = document.querySelectorAll('.auth-step');
    steps.forEach((step, index) => {
        step.classList.toggle('active', index + 1 === authStep);
    });
}

function nextAuthStep() {
    if (authStep < 3) {
        authStep++;
        updateAuthSteps();
    }
}

function prevAuthStep() {
    if (authStep > 1) {
        authStep--;
        updateAuthSteps();
    }
}

function selectPlan(planId) {
    const planCards = document.querySelectorAll('.plan-card');
    planCards.forEach(card => card.classList.remove('selected'));

    const selectedCard = document.querySelector(`#plan-${planId}`).closest('.plan-card');
    selectedCard.classList.add('selected');

    document.getElementById(`plan-${planId}`).checked = true;
}

function handleAuthSubmit(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);

    if (isAuthMode === 'login') {
        handleLogin(data);
    } else {
        handleRegister(data);
    }
}

function handleLogin(data) {
    // Simulation de connexion
    if (data.email === 'admin@fitlife.com' && data.password === 'admin') {
        currentUser = {
            email: 'admin@fitlife.com',
            nom: 'Admin',
            prenom: 'FitLife',
            role: 'admin'
        };
    } else {
        // Utilisateur normal pour démo
        currentUser = {
            email: data.email,
            nom: 'Utilisateur',
            prenom: 'Demo',
            abonnement: 'FitLight',
            objectif: 'Remise en forme',
            poids: 70,
            taille: 175
        };
    }

    saveUserSession();
    updateAuthUI();
    showSection('home');
    alert(`Bienvenue ${currentUser.prenom} !`);
}

function handleRegister(data) {
    const objectifs = {
        '1': 'Perte de poids',
        '2': 'Prise de muscle',
        '3': 'Remise en forme',
        '4': 'Maintien'
    };

    const abonnements = {
        '1': 'FitLight',
        '2': 'FitPlus'
    };

    currentUser = {
        email: data.email,
        nom: data.nom,
        prenom: data.prenom,
        poids: parseInt(data.poids),
        taille: parseInt(data.taille),
        objectif: objectifs[data.objectif],
        abonnement: abonnements[data.abonnement]
    };

    saveUserSession();
    updateAuthUI();
    showSection('home');
    alert(`Bienvenue ${currentUser.prenom} ! Votre compte a été créé.`);
}

function logout() {
    currentUser = null;
    localStorage.removeItem('fitlife_user');
    updateAuthUI();
    showSection('home');
    alert('Vous avez été déconnecté');
}

// Gestion de la session
function saveUserSession() {
    if (currentUser) {
        localStorage.setItem('fitlife_user', JSON.stringify(currentUser));
    }
}

function loadUserSession() {
    const userData = localStorage.getItem('fitlife_user');
    if (userData) {
        currentUser = JSON.parse(userData);
    }
}

// Affichage du profil
function updateProfileDisplay() {
    if (!currentUser) return;

    document.getElementById('profile-nom').textContent = currentUser.nom || '-';
    document.getElementById('profile-prenom').textContent = currentUser.prenom || '';
    document.getElementById('profile-email').textContent = currentUser.email || '-';
    document.getElementById('profile-abonnement').textContent = currentUser.abonnement || '-';
    document.getElementById('profile-objectif').textContent = currentUser.objectif || '-';
}

// Gestion de la progression
function updateProgressDisplay() {
    if (!currentUser) return;

    const objective = document.getElementById('progress-objective');
    const percent = document.getElementById('progress-percent');
    const fill = document.getElementById('progress-fill');

    objective.textContent = currentUser.objectif || 'Votre objectif';

    // Progression simulée
    const progress = Math.floor(Math.random() * 80) + 20;
    percent.textContent = progress;
    fill.style.width = progress + '%';

    // Stats simulées
    document.getElementById('stat-weight').textContent = currentUser.poids || 70;
    document.getElementById('stat-steps').textContent = Math.floor(Math.random() * 5000) + 5000;
    document.getElementById('stat-water').textContent = (Math.random() * 2 + 1).toFixed(1);
    document.getElementById('stat-sleep').textContent = (Math.random() * 2 + 7).toFixed(1);
}

function updateProgress() {
    // Simulation de mise à jour
    alert('Progression mise à jour !');
    updateProgressDisplay();
}