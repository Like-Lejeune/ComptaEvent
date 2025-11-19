<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription + Événement</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="{{ url('control/css/inscription.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="container">
    <img src="{{ url('control/images/nft/mtwlogo_dark.png')}}"alt="Logo"
             class="logo">
    <form id="multiForm" method="POST" enctype="multipart/form-data" action="{{ route('validation_inscription') }}">
        @csrf

        <!-- ÉTAPE 1 : USER -->
        <div class="step active" id="step1">

            <h2>Informations utilisateur</h2>
            <p style="color:#5f6368;font-size:20px;margin-bottom:25px;">Étape 1 sur 2</p>

            <div class="form-group">
                <label>Nom complet</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Pays</label>
                <input type="text" name="country">
            </div>

            <div class="form-group">
                <label>Téléphone</label>
                <input type="text" name="phone">
            </div>

            <button type="button" class="btn" onclick="nextStep()">Suivant</button>
            <a href="{{ route('identification') }}" class="actions">se connecter ?</a>
        </div>

        <!-- ÉTAPE 2 : EVENEMENT -->
        <div class="step" id="step2">

            <h2>Créer un événement</h2>
            <p style="ccolor:#5f6368;font-size:20px;margin-bottom:25px;">Étape 2 sur 2</p>

            <div class="form-group">
                <label>Nom de l'événement</label>
                <input type="text" name="nom" required   placeholder="Entrez le nom de votre projet">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description"></textarea>
            </div>

            <div class="form-group">
                <label>Date début</label>
                <input type="date" name="date_debut" required>
            </div>

            <div class="form-group">
                <label>Date fin</label>
                <input type="date" name="date_fin" required>
            </div>

            <div class="form-group">
                <label>Budget total</label>
                <input type="number" name="budget_total" required>
            </div>
            <!-- SERVICES -->
            <h3 style="margin-top:30px;">Services</h3>

            <div id="servicesContainer"></div>

            <button type="button" id="addServiceBtn" class="add-btn" onclick="addService()">+ Ajouter un service</button>

            <br><br>

            <button type="button" class="btn-secondary btn" onclick="prevStep()">Retour</button>
            <button type="submit" class="btn">Soumettre</button>
            <a href="{{ route('identification') }}" class="actions">se connecter ?</a>
        </div>

    </form>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let currentStep = 1;
    let serviceCount = 0;

    function nextStep() {
        document.getElementById("step1").classList.remove("active");
        document.getElementById("step2").classList.add("active");
    }

    function prevStep() {
        document.getElementById("step2").classList.remove("active");
        document.getElementById("step1").classList.add("active");
    }

    function addService() {
        if (serviceCount >= 4) return;

        serviceCount++;

        let box = document.createElement("div");
        box.className = "services-box";
        box.innerHTML = `
            <div class="service-title">Service ${serviceCount}</div>
            <div class="form-group">
                <label>Nom du service</label>
                <input type="text" class="s-name" name="services[${serviceCount}][s_name]" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="services[${serviceCount}][s_description]"></textarea>
            </div>
            <div class="form-group">
                <label>Budget</label>
                <input type="number" 
                       class="service-budget" 
                       name="services[${serviceCount}][s_budget]" 
                       min="0" 
                       required 
                       oninput="checkServiceBudgets()">
            </div>
        `;

        document.getElementById("servicesContainer").appendChild(box);

        if (serviceCount === 4) {
            document.getElementById("addServiceBtn").disabled = true;
        }
    }

    // 🔥 VERIFICATION 1 : Date Fin doit être >= Date Début
    document.addEventListener("DOMContentLoaded", () => {
        const dateDebut = document.querySelector("input[name='date_debut']");
        const dateFin = document.querySelector("input[name='date_fin']");

        function verifyDates() {
            if (dateDebut.value && dateFin.value && dateFin.value < dateDebut.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Date invalide',
                    text: 'La date de fin ne peut pas être antérieure à la date de début.',
                    confirmButtonColor: '#3085d6'
                });
                dateFin.value = "";
            }
        }

        dateDebut.addEventListener("change", verifyDates);
        dateFin.addEventListener("change", verifyDates);
    });

    let lastBudgetInput = null;

    // 🔥 VERIFICATION 2 : Budget total vs sommes des services
    function checkServiceBudgets(event) {
        const totalBudget = parseFloat(document.querySelector("input[name='budget_total']").value) || 0;
        const serviceBudgets = document.querySelectorAll(".service-budget");

        // On garde en mémoire le champ qui a changé
        if (event && event.target) {
            lastBudgetInput = event.target;
        }

        let sum = 0;
        serviceBudgets.forEach(input => {
            sum += parseFloat(input.value) || 0;
        });

        if (sum > totalBudget) {
            Swal.fire({
                icon: 'error',
                title: 'Budget dépassé',
                text: 'La somme des budgets des services dépasse le budget total.',
                confirmButtonColor: '#d33'
            }).then(() => {
                // ⚠️ Efface le champ fautif !
                if (lastBudgetInput) {
                    lastBudgetInput.value = "";
                }
            });
        }
    }

    // Re-vérifier quand le budget total change
    document.addEventListener("DOMContentLoaded", () => {
        const totalInput = document.querySelector("input[name='budget_total']");
        totalInput.addEventListener("input", checkServiceBudgets);

        // ⚠️ Ajoute l'événement sur CHAQUE budget de service
        document.addEventListener("input", (e) => {
            if (e.target.classList.contains("service-budget")) {
                checkServiceBudgets(e);
            }
        });
    });
</script>
</body>
</html>