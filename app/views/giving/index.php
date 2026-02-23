<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$paypalEmail = $paypalEmail ?? 'give@thelighthouseglobal.org';
$paypalUrl = $paypalUrl ?? '';
$stripeConfigured = $stripeConfigured ?? false;
$wallError = $_GET['error'] ?? null;
$designations = [
    'General' => 'General Fund',
    'Teaching' => 'Teaching & Discipleship',
    'Leadership' => 'Leadership Development',
    'Missions' => 'Outreach & Missions',
    'Operations' => 'Ministry Operations',
];
?>
<?php $givingHeroImg = page_hero_image('giving'); ?>
<section class="section giving-page" data-animate>
    <div class="page-hero page-hero--giving<?= page_hero_classes($givingHeroImg) ?>"<?= page_hero_style($givingHeroImg) ?>>
        <div class="container">
            <h1 class="page-hero-title">Giving & Partnership</h1>
            <p class="page-hero-sub">Your generosity advances the kingdom</p>
        </div>
    </div>

    <div class="container giving-content">
        <div class="giving-intro">
            <p class="giving-intro-lead">Giving is an act of worship and a covenant partnership in advancing God's kingdom.</p>
            <p class="giving-intro-supports">Your generosity supports:</p>
            <ul class="giving-intro-list">
                <li>Teaching & discipleship</li>
                <li>Leadership development</li>
                <li>Outreach & missions</li>
                <li>Ministry operations</li>
            </ul>
        </div>

        <?php if ($wallError === 'amount'): ?>
        <div class="giving-msg giving-msg--error" role="alert">
            <p>Please enter a minimum amount of $0.50 CAD.</p>
        </div>
        <?php elseif ($wallError === 'stripe'): ?>
        <div class="giving-msg giving-msg--error" role="alert">
            <p>Unable to process payment. Please ensure Stripe is configured in admin settings, or contact us to give via PayPal.</p>
        </div>
        <?php elseif ($wallError === 'csrf'): ?>
        <div class="giving-msg giving-msg--error" role="alert">
            <p>Invalid request. Please try again.</p>
        </div>
        <?php elseif ($wallError === 'payment'): ?>
        <div class="giving-msg giving-msg--error" role="alert">
            <p>Payment could not be verified. Please try again or contact us.</p>
        </div>
        <?php endif; ?>

        <div class="giving-options-grid">
            <?php if ($stripeConfigured): ?>
            <div class="giving-option-card giving-option-card--stripe">
                <div class="giving-option-header">
                    <span class="giving-option-badge">Online</span>
                    <h2 class="giving-option-title">Give via Stripe</h2>
                    <p class="giving-option-desc">Secure payment by credit or debit card. All amounts in Canadian dollars (CAD).</p>
                </div>
                <form class="giving-stripe-form" action="<?= $baseUrl ?>/giving/create-checkout" method="post">
                    <?= csrf_field() ?>
                    <div class="form-row form-row--amount">
                        <label for="give-amount">Amount (CAD) *</label>
                        <div class="amount-input-wrap">
                            <span class="amount-prefix">$</span>
                            <input type="number" id="give-amount" name="amount" step="0.01" min="0.50" required placeholder="25.00" value="<?= htmlspecialchars($_POST['amount'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="give-designation">Designation *</label>
                        <select id="give-designation" name="designation" required>
                            <?php foreach ($designations as $val => $label): ?>
                            <option value="<?= htmlspecialchars($val) ?>" <?= ($_POST['designation'] ?? '') === $val ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <label for="give-purpose">Purpose (optional)</label>
                        <input type="text" id="give-purpose" name="purpose" placeholder="e.g. Building fund, special offering" value="<?= htmlspecialchars($_POST['purpose'] ?? '') ?>">
                    </div>
                    <div class="form-row">
                        <label for="give-name">Your name (optional)</label>
                        <input type="text" id="give-name" name="donor_name" placeholder="For receipt" value="<?= htmlspecialchars($_POST['donor_name'] ?? '') ?>">
                    </div>
                    <div class="form-row">
                        <label for="give-email">Email (optional)</label>
                        <input type="email" id="give-email" name="donor_email" placeholder="For receipt" value="<?= htmlspecialchars($_POST['donor_email'] ?? '') ?>">
                    </div>
                    <button type="submit" class="btn btn-accent btn-giving-submit">Continue to Payment</button>
                </form>
            </div>
            <?php endif; ?>

            <div class="giving-option-card giving-option-card--paypal">
                <div class="giving-option-header">
                    <span class="giving-option-badge">PayPal</span>
                    <h2 class="giving-option-title">Give via PayPal</h2>
                    <p class="giving-option-desc">Send directly to our giving account.</p>
                    <p class="giving-option-email"><a href="mailto:<?= htmlspecialchars($paypalEmail) ?>"><?= htmlspecialchars($paypalEmail) ?></a></p>
                </div>
                <?php if (!empty($paypalUrl)): ?>
                <a href="<?= htmlspecialchars($paypalUrl) ?>" target="_blank" rel="noopener" class="btn btn-watch btn-giving-cta">Give via PayPal</a>
                <?php else: ?>
                <a href="mailto:<?= htmlspecialchars($paypalEmail) ?>?subject=Giving%20Inquiry" class="btn btn-watch btn-giving-cta">Contact to Give</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="giving-note">
            <p>For other giving platforms (bank transfer, etc.), please contact us at <a href="mailto:<?= htmlspecialchars($paypalEmail) ?>"><?= htmlspecialchars($paypalEmail) ?></a> or <a href="mailto:info@thelighthouseglobal.org">info@thelighthouseglobal.org</a>.</p>
        </div>

        <div class="giving-cta">
            <a href="<?= $baseUrl ?>/contact" class="btn btn-outline">Contact Us</a>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'Give - Lighthouse Global Church';
$pageDescription = 'Partner with Lighthouse through giving. Support teaching, leadership, and missions.';
require APP_PATH . '/views/layouts/main.php';
?>
