<?php include 'includes/header.php'; ?>

    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <div class="page-tagline gold">Get in Touch</div>
                <h1 class="page-title">Contact <span class="gold">Us Today</span></h1>
                <p class="page-description">Experience premium security services with our elite protection solutions</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-grid">
                <!-- Contact Information -->
                <div class="contact-info">
                    <div class="info-header">
                        <div class="section-subtitle gold">Our Offices</div>
                        <h2>Get in <span class="gold">Touch</span></h2>
                        <p class="info-description">We're here to help you with all your premium security and manpower needs. Contact us for a consultation or quote.</p>
                    </div>
                     
                    <div class="contact-details">
                        <div class="contact-detail-card address-box">
    <div class="contact-icon gold">
        <i class="fas fa-map-marker-alt"></i>
    </div>

    <div class="contact-content">
        <h3>Our Office Addresses</h3>
        <div class="address-list">
            <div class="address-item">
                <span class="address-title">Patna (Head Office)</span>
                <p>117, Road No - 8, S.K Nagar, Budha Colony, Patna, Bihar – 800001</p>
            </div>
            <div class="address-item">
                <span class="address-title">Jharkhand Branch</span>
                <p>Hanuman Mandir, Khata No - 67, Plot No - 1011, RJ Villa Dawarika Puri, Lower Chutia, Ranchi, Jharkhand – 834001</p>
            </div>
        </div>
    </div>
</div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="contact-form-container">
                    <div class="form-header">
                        <div class="section-subtitle gold">Request Consultation</div>
                        <h2>Send us a <span class="gold">Message</span></h2>
                        <p class="form-description">Fill out the form below and our team will contact you within 24 hours</p>
                    </div>

                    <form id="contactForm" class="contact-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Full Name *</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-user gold"></i>
                                    <input type="text" id="name" name="name" required placeholder="Enter your full name">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">Phone Number *</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-phone gold"></i>
                                    <input type="tel" id="phone" name="phone" required placeholder="Enter your 10-digit phone number">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-envelope gold"></i>
                                    <input type="email" id="email" name="email" placeholder="Enter your email address">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="organization">Organization / Company</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-building gold"></i>
                                    <input type="text" id="organization" name="organization" placeholder="Enter organization name">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="service">Service Required *</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-shield-alt gold"></i>
                                    <select id="service" name="service" required>
                                        <option value="">Select a service</option>
                                        <option value="security">Security Guard Services</option>
                                        <option value="manpower">Skilled Manpower Supply</option>
                                        <option value="housekeeping">Housekeeping Services</option>
                                        <option value="technical">Technical Manpower</option>
                                        <option value="corporate">Corporate Security</option>
                                        <option value="education">Educational Institution Security</option>
                                        <option value="government">Government Department Security</option>
                                        <option value="other">Other Services</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="location">Location / City *</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-map-marker-alt gold"></i>
                                    <input type="text" id="location" name="location" required placeholder="Enter your city">
                                </div>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="message">Message / Requirements *</label>
                            <div class="textarea-with-icon">
                                <i class="fas fa-comment gold"></i>
                                <textarea id="message" name="message" rows="5" required placeholder="Describe your security or manpower requirements"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn-gold">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>

                    <div id="formMessage" class="form-message" style="margin-top: 20px;"></div>
                </div>
            </div>
        </div>
    </section>

<script>
$(document).ready(function() {
    $('#contactForm').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        $('#formMessage').html('<p style="color: gold;">Sending message...</p>');

        $.ajax({
            url: 'contact_process.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#formMessage').html('<div class="alert alert-success" style="color: #00ff00; background: rgba(0,255,0,0.1); padding: 10px; border-radius: 5px;">' + response.message + '</div>');
                    $('#contactForm')[0].reset();
                } else {
                    $('#formMessage').html('<div class="alert alert-danger" style="color: #ff0000; background: rgba(255,0,0,0.1); padding: 10px; border-radius: 5px;">' + response.message + '</div>');
                }
            },
            error: function() {
                $('#formMessage').html('<p style="color: #ff0000;">An error occurred. Please try again later.</p>');
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
