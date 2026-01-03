<style>
    .modern-footer {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 20px 20px;
        margin-top: 80px;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        text-align: center;
    }

    .footer-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .footer-subtitle {
        opacity: 0.9;
        margin-bottom: 30px;
    }

    .footer-divider {
        width: 60px;
        height: 3px;
        background: white;
        margin: 20px auto;
        border-radius: 2px;
    }

    .footer-links {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .footer-link {
        color: white;
        text-decoration: none;
        opacity: 0.9;
        transition: opacity 0.3s;
    }

    .footer-link:hover {
        opacity: 1;
        text-decoration: underline;
    }

    .footer-bottom {
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.2);
        font-size: 0.9rem;
        opacity: 0.8;
    }

    @media (max-width: 768px) {
        .footer-links {
            flex-direction: column;
            gap: 15px;
        }
    }
</style>

<footer class="modern-footer">
    <div class="footer-content">
        <div class="footer-title">Transaction Escrow System</div>
        <div class="footer-subtitle">Secure. Fast. Trusted.</div>
        
        <div class="footer-divider"></div>
        
        <div class="footer-links">
            <a href="#" class="footer-link">About</a>
            <a href="#" class="footer-link">How It Works</a>
            <a href="#" class="footer-link">Privacy Policy</a>
            <a href="#" class="footer-link">Terms of Service</a>
            <a href="#" class="footer-link">Contact</a>
        </div>
        
        <div class="footer-bottom">
            © {{ date('Y') }} Transaction Escrow System — Final Project UAS
        </div>
    </div>
</footer>