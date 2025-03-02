// Fonction pour récupérer les statistiques via l'API
async function fetchStats(url) {
    try {
        const response = await fetch(url);
        return await response.json();
    } catch (error) {
        console.error('Erreur lors du chargement des données:', error);
        return null;
    }
}

// 1️⃣ Charger le nombre total d'utilisateurs avec vérification
async function loadTotalUsers() {
    const data = await fetchStats('/api/stats/total-users');
    console.log("Total utilisateurs reçus:", data); // ✅ Vérification dans la console

    if (data) {
        document.getElementById('totalUsers').innerText = data.total_users;
    }
}

// 2️⃣ Charger les utilisateurs par rôle et afficher dans un graphique avec des couleurs améliorées
async function loadUsersByRole() {
    const data = await fetchStats('/api/stats/users-by-role');
    console.log("Données des utilisateurs par rôle:", data); // ✅ Vérification dans la console

    if (data) {
        const ctx = document.getElementById('usersByRoleChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(item => item.role),
                datasets: [{
                    label: 'Nombre d\'utilisateurs',
                    data: data.map(item => item.count),
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',  // Bleu
                        'rgba(75, 192, 192, 0.7)',  // Vert
                        'rgba(255, 206, 86, 0.7)'   // Jaune
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,   // ✅ Démarrer l'axe Y à 0
                        ticks: { stepSize: 1 }  // ✅ Incrémentation par 1
                    }
                }
            }
        });
    }
}

// 3️⃣ Charger les inscriptions mensuelles et afficher dans un graphique
async function loadMonthlyRegistrations() {
    const data = await fetchStats('/api/stats/monthly-registrations');
    console.log("Données des inscriptions mensuelles:", data); // ✅ Vérification dans la console

    const container = document.getElementById('monthlyRegistrationsChart');

    if (data && data.length > 0) {
        const months = data.map(item => item.month);
        const counts = data.map(item => item.count);

        const ctx = container.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Inscriptions mensuelles',
                    data: counts,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,  // ✅ Démarrer l'axe Y à 0
                        ticks: { stepSize: 1 }  // ✅ Incrémentation par 1
                    }
                }
            }
        });
    } else {
        console.warn("⚠️ Aucune donnée trouvée pour les inscriptions mensuelles.");
        container.parentElement.innerHTML = "<p class='text-center text-danger'>Aucune inscription récente.</p>"; // ✅ Affichage d'un message si vide
    }
}

// Lancer les chargements au démarrage
document.addEventListener("DOMContentLoaded", function () {
    loadTotalUsers();
    loadUsersByRole();
    loadMonthlyRegistrations();
});
