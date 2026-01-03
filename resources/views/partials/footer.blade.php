<style>
    .premium-footer {
        background: #0f172a;
        color: #e2e8f0;
        padding: 60px 0 30px;
        margin-top: auto;
        border-top: 1px solid rgba(255,255,255,0.05);
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1.5fr;
        gap: 40px;
    }

    .footer-brand h3 {
        color: white;
        font-size: 1.5rem;
        margin-bottom: 15px;
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .footer-brand p {
        color: #94a3b8;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    .footer-col h4 {
        color: white;
        font-size: 1.1rem;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .footer-links {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .footer-links a {
        color: #94a3b8;
        text-decoration: none;
        transition: color 0.2s;
        font-size: 0.95rem;
    }

    .footer-links a:hover {
        color: #6366f1;
        padding-left: 5px;
    }

    .newsletter-form {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .newsletter-input {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        padding: 10px 15px;
        border-radius: 8px;
        color: white;
        width: 100%;
        outline: none;
        transition: border-color 0.2s;
    }

    .newsletter-input:focus {
        border-color: #6366f1;
    }

    .btn-sub {
        background: #6366f1;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.2s;
    }

    .btn-sub:hover {
        background: #4f46e5;
    }

    .footer-bottom {
        max-width: 1200px;
        margin: 60px auto 0;
        padding: 30px 20px 0;
        border-top: 1px solid rgba(255,255,255,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #64748b;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .footer-container {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .footer-bottom {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
    }
</style>

<footer class="premium-footer">
    <div class="footer-container">
        <div class="footer-brand">
            <h3 style="margin-top: 0;">EscrowSecure</h3>
            <p>
                The most trusted platform for secure digital transactions. 
                We protect both buyers and sellers with our advanced escrow technology.
            </p>
        </div>

        <div class="footer-col">
            <h4>Platform</h4>
            <div class="footer-links">
                <a href="#">How it Works</a>
                <a href="#">Security</a>
                <a href="#">Pricing</a>
                <a href="#">API Docs</a>
            </div>
        </div>

        <div class="footer-col">
            <h4>Company</h4>
            <div class="footer-links">
                <a href="#">About Us</a>
                <a href="#">Careers</a>
                <a href="#">Blog</a>
                <a href="#">Contact</a>
            </div>
        </div>

        <div class="footer-col">
            <h4>Stay Updated</h4>
            <p style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 15px;">
                Subscribe to our newsletter for the latest updates.
            </p>
            <div class="newsletter-form">
                <input type="email" placeholder="Enter email" class="newsletter-input">
                <button class="btn-sub">→</button>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div>© {{ date('Y') }} EscrowSecure Framework. All rights reserved.</div>
        <div style="display: flex; gap: 20px;">
            <a href="#" style="color: #64748b; text-decoration: none;">Privacy</a>
            <a href="#" style="color: #64748b; text-decoration: none;">Terms</a>
        </div>
    </div>
</footer>