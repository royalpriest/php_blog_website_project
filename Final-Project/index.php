<?php
// page metadata
session_name("HUB_SESSION");
session_start();
$pageDescription = "This is the home page which gives the overview of what the website is about";
$pageTitle = "Home Page";

// Include header template
require 'inc/header.php';
?>

    <main>
        <!-- Welcome -->
        <section class="welcome">
            <div class="welcome-content">
                <h1>Welcome to Programmer Hub</h1>
                <p>At Programmer Hub, we are building a vibrant space where developers connect, collaborate, and grow together. Whether you're a beginner or a seasoned coder, this platform lets you share your ideas, ask questions, and post code snippets in real time.</p>
                <p>Think of it as a mix between a coding-focused social media feed and a collaborative Q&A space—like Twitter meets Stack Overflow. Join us and become part of a community where programmers support and inspire each other every day.</p>
            </div>
        </section>

        <!-- Features showcase section -->
        <section class="features">
            <h2>Why Choose Programmer Hub?</h2>
            <div class="features-grid">
                <!-- Feature 1: Code Sharing -->
                <div class="feature">
                    <div class="feature-content">
                        <h3>Code Sharing</h3>
                        <p class="feature-about">Post and discuss code snippets in real time, share ideas and get feedback instantly. Collaborate with other developers on projects and get help with debugging.</p>
                    </div>
                    <div class="feature-img-container">
                        <img src="images/cardimg1.jpg" alt="Code collaboration">
                    </div>
                </div>

                <!-- Feature 2: Active Community -->
                <div class="feature">
                    <div class="feature-content">
                        <h3>Active Community</h3>
                        <p class="feature-about">Get answers from developers at all skill levels. Our community is here to help you grow, whether you're a beginner or an expert. the community is here to help you at every turn.</p>
                    </div>
                    <div class="feature-img-container">
                        <img src="images/cardimg2.jpg" alt="Developer community">
                    </div>
                </div>

                <!-- Feature 3: Fast Responses -->
                <div class="feature">
                    <div class="feature-content">
                        <h3>Fast Responses</h3>
                        <p class="feature-about">Average reply time under 30 minutes. Our community is active and responsive, ensuring you get the help you need quickly, long wait time and delay is non existent.</p>
                    </div>
                    <div class="feature-img-container">
                        <img src="images/cardimg7.jpeg" alt="Quick response stats">
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials section -->
        <section class="testimonials">
            <h2 id="testimonials-heading">What Developers have to Say</h2>
            <div class="testimonial-grid">
                <!-- Testimonial 1 -->
                <div class="testimonial-card">
                    <blockquote>"Saved me hours of debugging! The community here is incredibly supportive."</blockquote>
                    <div class="author">
                        <img src="images/avatar2.jpeg" alt="Blossom B.">
                        <p>Blossom B.<br><span>Frontend Developer</span></p>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="testimonial-card">
                    <blockquote>"Like Stack Overflow but with a social twist. Love it! with a community that has your back!!"</blockquote>
                    <div class="author">
                        <img src="images/avatar1.jpeg" alt="Ayo A.">
                        <p>Ayo A.<br><span>Data Scientist</span></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call-to-action section -->
        <section class="final-cta">
            <div class="cta-container">
                <h2>Ready to Level Up Your Coding Skills?</h2>
                <p class="cta-subtext">Join our community of passionate developers</p>
                <a href="register.php" class="cta-button">Sign Up Free</a>
            </div>
        </section>
    </main>

    <!-- Include footer template -->
<?php require './inc/footer.php'; ?>