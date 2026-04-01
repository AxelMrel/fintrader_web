<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrat #{{ $contract->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #1a1a2e;
            background: #ffffff;
            padding: 40px;
        }

        /* HEADER */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 24px;
            border-bottom: 3px solid #f0a500;
        }

        .logo-block .logo {
            font-size: 28px;
            font-weight: 900;
            color: #1a1a2e;
            letter-spacing: -1px;
        }

        .logo-block .logo span {
            color: #f0a500;
        }

        .logo-block .tagline {
            font-size: 10px;
            color: #888;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .contract-ref {
            text-align: right;
        }

        .contract-ref .ref-label {
            font-size: 10px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .contract-ref .ref-number {
            font-size: 20px;
            font-weight: 900;
            color: #f0a500;
            margin-top: 2px;
        }

        .contract-ref .ref-date {
            font-size: 10px;
            color: #888;
            margin-top: 4px;
        }

        /* TITLE */
        .title-block {
            text-align: center;
            margin-bottom: 32px;
        }

        .title-block h1 {
            font-size: 18px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #1a1a2e;
        }

        .title-block .subtitle {
            font-size: 11px;
            color: #888;
            margin-top: 6px;
        }

        .title-divider {
            width: 60px;
            height: 3px;
            background: #f0a500;
            margin: 10px auto 0;
        }

        /* PARTIES */
        .parties {
            display: flex;
            gap: 20px;
            margin-bottom: 28px;
        }

        .party-block {
            flex: 1;
            background: #f8f8f8;
            border-radius: 10px;
            padding: 16px 20px;
            border-left: 4px solid #f0a500;
        }

        .party-block .party-label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #f0a500;
            margin-bottom: 8px;
        }

        .party-block .party-name {
            font-size: 14px;
            font-weight: 900;
            color: #1a1a2e;
        }

        .party-block .party-info {
            font-size: 10px;
            color: #666;
            margin-top: 3px;
        }

        /* SECTION */
        .section {
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #1a1a2e;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e5e5e5;
        }

        /* GRID */
        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .grid-item {
            flex: 1;
            min-width: 140px;
            background: #f8f8f8;
            border-radius: 8px;
            padding: 12px 14px;
        }

        .grid-item .item-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #999;
            margin-bottom: 4px;
        }

        .grid-item .item-value {
            font-size: 14px;
            font-weight: 900;
            color: #1a1a2e;
        }

        .grid-item.highlight {
            background: #1a1a2e;
        }

        .grid-item.highlight .item-label {
            color: #f0a500;
        }

        .grid-item.highlight .item-value {
            color: #ffffff;
        }

        /* CLAUSES */
        .clause {
            margin-bottom: 12px;
            padding-left: 14px;
            border-left: 2px solid #f0a500;
        }

        .clause .clause-title {
            font-size: 11px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 3px;
        }

        .clause .clause-text {
            font-size: 10px;
            color: #555;
            line-height: 1.6;
        }

        /* STATUS */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: #fff3cd;
            color: #856404;
        }

        /* SIGNATURES */
        .signatures {
            display: flex;
            gap: 40px;
            margin-top: 40px;
            padding-top: 24px;
            border-top: 1px solid #e5e5e5;
        }

        .sig-block {
            flex: 1;
            text-align: center;
        }

        .sig-block .sig-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 40px;
        }

        .sig-block .sig-line {
            border-top: 1px solid #1a1a2e;
            padding-top: 6px;
            font-size: 10px;
            color: #555;
        }

        .sig-block .sig-name {
            font-size: 12px;
            font-weight: 700;
            color: #1a1a2e;
            margin-top: 4px;
        }

        /* FOOTER */
        .footer {
            margin-top: 32px;
            padding-top: 16px;
            border-top: 1px solid #e5e5e5;
            text-align: center;
            font-size: 9px;
            color: #aaa;
            line-height: 1.8;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="logo-block">
            <div class="logo">FIN<span>TRADER</span></div>
            <div class="tagline">Plateforme d'investissement</div>
        </div>
        <div class="contract-ref">
            <div class="ref-label">Contrat N°</div>
            <div class="ref-number">#{{ str_pad($contract->id, 5, '0', STR_PAD_LEFT) }}</div>
            <div class="ref-date">Signé le {{ $contract->accepted_at->format('d/m/Y à H:i') }}</div>
        </div>
    </div>

    {{-- TITRE --}}
    <div class="title-block">
        <h1>Contrat d'investissement</h1>
        <div class="subtitle">{{ $contract->template->name }}</div>
        <div class="title-divider"></div>
    </div>

    {{-- PARTIES --}}
    <div class="parties">
        <div class="party-block">
            <div class="party-label">Le Gestionnaire</div>
            <div class="party-name">FINTRADER</div>
            <div class="party-info">Plateforme d'investissement agréée</div>
            <div class="party-info">admin@mytrade.com</div>
        </div>
        <div class="party-block">
            <div class="party-label">Le Client / Investisseur</div>
            <div class="party-name">{{ $contract->client->first_name }} {{ $contract->client->last_name }}</div>
            <div class="party-info">{{ $contract->client->email }}</div>
            <div class="party-info">Client depuis le {{ $contract->client->created_at->format('d/m/Y') }}</div>
        </div>
    </div>

    {{-- DÉTAILS DU CONTRAT --}}
    <div class="section">
        <div class="section-title">Détails financiers</div>
        <div class="grid">
            <div class="grid-item highlight">
                <div class="item-label">Capital investi</div>
                <div class="item-value">{{ number_format($contract->capital, 0, ',', ' ') }} {{ $contract->currency }}</div>
            </div>
            <div class="grid-item">
                <div class="item-label">Frais d'entrée</div>
                <div class="item-value">{{ number_format($contract->entry_fees, 0, ',', ' ') }} {{ $contract->currency }}</div>
            </div>
            <div class="grid-item">
                <div class="item-label">Durée</div>
                <div class="item-value">{{ $contract->duration_months }} mois</div>
            </div>
            <div class="grid-item">
                <div class="item-label">Statut</div>
                <div class="item-value">
                    <span class="status-badge">En attente</span>
                </div>
            </div>
        </div>
    </div>

    {{-- RÉPARTITION --}}
    <div class="section">
        <div class="section-title">Répartition des bénéfices</div>
        <div class="grid">
            <div class="grid-item">
                <div class="item-label">Part investisseur</div>
                <div class="item-value">{{ $contract->investor_share }}%</div>
            </div>
            <div class="grid-item">
                <div class="item-label">Part gestionnaire</div>
                <div class="item-value">{{ $contract->manager_share }}%</div>
            </div>
            <div class="grid-item">
                <div class="item-label">Protection du capital</div>
                <div class="item-value">{{ $contract->capital_protection }}%</div>
            </div>
            <div class="grid-item">
                <div class="item-label">Pénalité retrait anticipé</div>
                <div class="item-value">{{ $contract->early_withdrawal_penalty }}%</div>
            </div>
        </div>
    </div>

    {{-- CLAUSES --}}
    <div class="section">
        <div class="section-title">Clauses du contrat</div>

        <div class="clause">
            <div class="clause-title">1. Objet du contrat</div>
            <div class="clause-text">
                Le client confie à FINTRADER un capital de
                <strong>{{ number_format($contract->capital, 0, ',', ' ') }} {{ $contract->currency }}</strong>
                pour une durée de <strong>{{ $contract->duration_months }} mois</strong>,
                aux fins de gestion et d'investissement sur les marchés financiers.
            </div>
        </div>

        <div class="clause">
            <div class="clause-title">2. Répartition des profits</div>
            <div class="clause-text">
                Les bénéfices générés seront répartis à hauteur de
                <strong>{{ $contract->investor_share }}%</strong> pour l'investisseur et
                <strong>{{ $contract->manager_share }}%</strong> pour le gestionnaire.
                En cas de perte, la protection du capital garantit
                <strong>{{ $contract->capital_protection }}%</strong> du capital initial.
            </div>
        </div>

        <div class="clause">
            <div class="clause-title">3. Retrait anticipé</div>
            <div class="clause-text">
                Tout retrait avant l'échéance du contrat entraîne une pénalité de
                <strong>{{ $contract->early_withdrawal_penalty }}%</strong> sur le capital retiré.
            </div>
        </div>

        <div class="clause">
            <div class="clause-title">4. Acceptation</div>
            <div class="clause-text">
                Le client déclare avoir pris connaissance et accepté l'ensemble des conditions
                de ce contrat le <strong>{{ $contract->accepted_at->format('d/m/Y à H:i') }}</strong>.
            </div>
        </div>
    </div>

    {{-- SIGNATURES --}}
    <div class="signatures">
        <div class="sig-block">
            <div class="sig-label">Signature du gestionnaire</div>
            <div class="sig-line">
                <div class="sig-name">FINTRADER</div>
            </div>
        </div>
        <div class="sig-block">
            <div class="sig-label">Signature du client</div>
            <div class="sig-line">
                <div class="sig-name">{{ $contract->client->first_name }} {{ $contract->client->last_name }}</div>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        Ce document est un contrat officiel généré automatiquement par la plateforme FINTRADER.<br>
        Contrat N° {{ str_pad($contract->id, 5, '0', STR_PAD_LEFT) }} — Généré le {{ now()->format('d/m/Y à H:i') }}<br>
        © {{ now()->year }} FINTRADER — Tous droits réservés
    </div>

</body>
</html>