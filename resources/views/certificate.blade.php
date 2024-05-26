<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attestation de Solde</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white flex flex-col min-h-screen">
<div class="max-w-4xl mx-auto p-10 flex-grow">
    <!-- Entête avec le logo et le texte -->
    <div class="flex items-center mb-5">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo" class="h-40">
        <div class="text-center ml-4">
            <p class="text-2xl font-bold underline">MONEY FINANCE INTERNATIONAL</p>
        </div>
    </div>
    <!-- Reference -->
    <div class="mb-5">
        <p class="font-bold"><span class="underline">REF</span>: N°2024/02/19/0102</p>
    </div>

    <!-- Contenu principal -->
    <div class="text-center mb-5">
        <h1 class="text-xl font-bold underline">ATTESTATION DE SOLDE</h1>
    </div>
    <div class="mb-10 text-xs">
        <p><span class="ml-16"></span> Nous soussignés, <span class="font-bold">Money Finance International (MFI)</span> de Côte d’Ivoire, Société SA au capital de FCFA 1.000.000.000 (Un milliard de francs) dont le siège social est à Abidjan-Marcory, Rue de l’Industrie face Zone 3, 03 BP 2092 Abidjan 03, Attestons par la présente que :</p>
        <p class="mt-4"><span class="font-bold">{{ $name }}</span> , est titulaire d’un compte courant <span class="font-bold">N°{{ $account_number }}</span> dans les livres de la Money Finance International (MFI) de Côte d’Ivoire Agence d’Adjamé 220 logements.</p>
        <p class="mt-4">A compter de l’ouverture jusqu’à ce jour, ce compte est en mouvement, nous certifions son existence et son authenticité.</p>
        <p class="mt-4">Ce compte présente à ce jour, un solde de <span class="font-bold">FCFA {{ $amount }} ({{ $letter }} francs CFA).</span> </p>
        <p class="mt-4">En foi de quoi, nous la délivrons la présente Attestation pour servir et valoir ce que de droit.</p>
    </div>
    <div class="text-right mb-10">
        <p class="font-bold text-sm">Fait Abidjan, le {{$date}} <span class="ml-8"></span> </p>
        <p class="mt-16 font-bold underline text-sm">Money Finance International (MFI)- Côte d’Ivoire</p>
    </div>
</div>
<!-- Pied de page en bleu -->
<footer class="text-blue-500 text-left text-xs pl-10 pr-6">
    <div>
        <p>Caisse d’Epargne et Crédit au Capital de 1.000.000.000 Frs cfa – Siège Social : Abidjan Rue de L’Industrie face zone 3</p>
        <p>03 BP 2092 Abidjan 03 – Tel : 20 00 60 96 /Fax : 25 20 00 60 97 - RCN° CI-ABJ- 2012-B -5212 – CCN° 0150723K-Arrête N877/MEMEF/DT – Agrément: A1.2.2.12/04-12– Site web : www.mfi-ci.com -Email : info@mfi.ci –Agences : Adjamé-Treichville-Marcory</p>
    </div>
    <div class="bg-yellow-100 h-5 mt-2 ml-2 mr-16 mb-6"></div>
</footer>
</body>
</html>
