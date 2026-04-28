<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <div class="page-tagline gold">Our Premium Services</div>
                <h1 class="page-title">Elite <span class="gold">Security Solutions</span></h1>
                <p class="page-description">Comprehensive security and manpower services tailored for excellence across all sectors</p>
            </div>
        </div>
    </section>

               <?php 
include 'config/db.php';

$services = $pdo->query("SELECT * FROM services ORDER BY id DESC")->fetchAll();

$i = 0;
$icons = ['fa-users', 'fa-broom', 'fa-shield-alt', 'fa-tools'];
?>

<!-- ✅ GRID START (IMPORTANT) -->
<div class="service-grid">

<?php
foreach ($services as $s) {
    $icon = $icons[$i % count($icons)];
    $i++;

    $features = explode(',', $s['features']);
?>
    <div class="detailed-service-card">

        <!-- ICON -->
        <div class="service-card-header">
            <div class="service-icon">
                <i class="fas <?php echo $icon; ?>"></i>
            </div>
            <h4><?php echo htmlspecialchars($s['service_name']); ?></h4>
        </div>

        <!-- DESCRIPTION -->
        <div class="service-card-content">
            <p><?php echo htmlspecialchars($s['description']); ?></p>

            <!-- ✅ FEATURES -->
       <ul class="service-features">
<?php foreach ($features as $f) { 

    // ✅ STRONG CLEAN (remove all symbols + extra spaces)
    $clean = preg_replace('/[^a-zA-Z0-9\s]/u', '', $f);
    $clean = trim($clean);

    if (!empty($clean)) {
?>
    <li>
        <i class="fas fa-check gold"></i>
        <?php echo htmlspecialchars($clean); ?>
    </li>
<?php } } ?>
</ul>
  </div>

    </div>
<?php } ?>

</div>
 </div>

            
    
    <section class="service-process">
        <div class="container">
            <div class="section-header">
                <div class="section-subtitle gold">Our Process</div>
                <h2>Service <span class="gold">Delivery Process</span></h2>
                <p class="section-description">A systematic approach ensuring excellence at every step</p>
            </div>

            <div class="process-timeline">
                <div class="process-step">
                    <div class="step-number gold">01</div>
                    <div class="step-content">
                        <h3>Requirement Analysis</h3>
                        <p>Comprehensive analysis of your specific security and manpower needs</p>
                    </div>
                </div>

                <div class="process-step">
                    <div class="step-number gold">02</div>
                    <div class="step-content">
                        <h3>Personnel Selection</h3>
                        <p>Careful selection of trained and verified personnel matching your requirements</p>
                    </div>
                </div>

                <div class="process-step">
                    <div class="step-number gold">03</div>
                    <div class="step-content">
                        <h3>Deployment</h3>
                        <p>Quick deployment of staff with proper orientation and site familiarization</p>
                    </div>
                </div>

                <div class="process-step">
                    <div class="step-number gold">04</div>
                    <div class="step-content">
                        <h3>Monitoring & Support</h3>
                        <p>Continuous monitoring and 24/7 support for service quality assurance</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Areas -->
    <section class="service-areas">
        <div class="container">
            <div class="section-header">
                <div class="section-subtitle gold">Our Coverage</div>
                <h2>Service <span class="gold">Areas</span></h2>
                <p class="section-description">Comprehensive coverage across Bihar, Jharkhand, and Uttar Pradesh</p>
            </div>

            <div class="areas-grid">
                <div class="area-card">
                    <div class="area-header">
                        <div class="area-icon gold">
                            <i class="fas fa-map-pin"></i>
                        </div>
                        <h3>Bihar Operations</h3>
                    </div>
                    <ul class="area-list">
                        <li><i class="fas fa-check gold"></i> Patna</li>
                        <li><i class="fas fa-check gold"></i> Gaya</li>
                        <li><i class="fas fa-check gold"></i> Bhagalpur</li>
                        <li><i class="fas fa-check gold"></i> Muzaffarpur</li>
                        <li><i class="fas fa-check gold"></i> Purnea</li>
                        <li><i class="fas fa-check gold"></i> Darbhanga</li>
                        <li><i class="fas fa-check gold"></i> Biharsharif</li>
                        <li><i class="fas fa-check gold"></i> Arrah</li>
                    </ul>
                </div>

                <div class="area-card">
                    <div class="area-header">
                        <div class="area-icon gold">
                            <i class="fas fa-map-pin"></i>
                        </div>
                        <h3>Jharkhand Services</h3>
                    </div>
                    <ul class="area-list">
                        <li><i class="fas fa-check gold"></i> Ranchi</li>
                        <li><i class="fas fa-check gold"></i> Jamshedpur</li>
                        <li><i class="fas fa-check gold"></i> Dhanbad</li>
                        <li><i class="fas fa-check gold"></i> Bokaro</li>
                        <li><i class="fas fa-check gold"></i> Hazaribagh</li>
                        <li><i class="fas fa-check gold"></i> Deoghar</li>
                        <li><i class="fas fa-check gold"></i> Giridih</li>
                        <li><i class="fas fa-check gold"></i> Ramgarh</li>
                    </ul>
                </div>

                <div class="area-card">
                    <div class="area-header">
                        <div class="area-icon gold">
                            <i class="fas fa-map-pin"></i>
                        </div>
                        <h3>Uttar Pradesh</h3>
                    </div>
                    <ul class="area-list">
                        <li><i class="fas fa-check gold"></i> Varanasi</li>
                        <li><i class="fas fa-check gold"></i> Lucknow</li>
                        <li><i class="fas fa-check gold"></i> Prayagraj</li>
                        <li><i class="fas fa-check gold"></i> Gorakhpur</li>
                        <li><i class="fas fa-check gold"></i> Kanpur</li>
                        <li><i class="fas fa-check gold"></i> Agra</li>
                        <li><i class="fas fa-check gold"></i> Ghaziabad</li>
                        <li><i class="fas fa-check gold"></i> Meerut</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    
    <section class="cta">
        <div class="cta-overlay"></div>
        <div class="container">
            <div class="cta-content">
                <h2>Ready for <span class="gold">Premium Security?</span></h2>
                <p>Contact us today for elite security and manpower solutions tailored to your needs</p>
                <div class="cta-btns">
                    <a href="contact.php" class="btn-gold">Get Custom Quote <i class="fas fa-file-contract"></i></a>
                    <a href="tel:9386831906" class="btn-outline">Call Now: 7004422944/ 9852572995</a>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>