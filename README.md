# 🪙 CryptoCoin Staking & Mining Platform

A full-stack, enterprise **Cryptocurrency Staking, Cloud Mining, and Token Yield Platform** engineered with **Laravel 11, PHP 8.3, and MySQL**. Features automated staking return calculation, token conversion engines, multi-tier investment packages, automated reward disbursement via cron jobs, and institutional-grade financial security.

---

## 🌟 Key Features

### 💎 Staking & Yield Farming
- **Flexible & Locked Staking Pools:** Deposit digital assets into smart yield pools with configurable lock durations and dynamic APY/APR.
- **Automated Yield Disbursement:** Background cron scheduler (`/cron/staking`) handles daily compounding and payout calculations without manual intervention.
- **Instant Token Conversion:** Built-in decentralized exchange/conversion desk allowing members to swap between platform tokens and major currencies.

### ⛏️ Cloud Mining & Earning Modules
- **Interactive Mining Dashboard:** Monitor hashrates, mining rigs, daily output, and equipment lifespan.
- **Tiered Staking Plans:** Flexible subscription tiers with variable minimum deposit requirements, daily ROI rates, and principal return guarantees.
- **Affiliate Team Commissions:** Multi-tier referral reward structure paying direct commissions on downline staking volume and daily yields.

### 💳 Payments & Gateway Integration
- **20+ Supported Payment Gateways:** Automated cryptocurrency deposit handlers (BTCPayServer, CoinGate) plus global fiat gateways (Stripe, Razorpay, Mollie, Authorize.Net, Flutterwave, Paystack).
- **KYC & Security Verification:** Complete identity documentation upload, automated reviewer workflow, and Google 2-Factor Authentication (2FA).
- **Withdrawal Safeguards:** Admin moderation, withdrawal limit tiers, and real-time ledger accounting.

---

## 🛠️ Tech Stack

- **Framework:** Laravel 11.x, PHP 8.3
- **Database:** MySQL 8.0+ / MariaDB 10.4+
- **Security & Integrity:** Double-entry ledger architecture, CSRF/XSS protection, rate limiting, and bcrypt hashing
- **Automation:** Laravel Queue System, Web Crons (`cron/staking`)

---

## 📦 Setup & Deployment

### 1. Prerequisites
- PHP 8.2 or 8.3 with extensions: `pdo_mysql`, `curl`, `fileinfo`, `gd`, `openssl`, `mbstring`
- Composer 2.x
- MySQL / MariaDB

### 2. Installation
```bash
git clone https://github.com/ranaumairnawaz/CryptoCoinStakingMiningPlatform.git
cd CryptoCoinStakingMiningPlatform

cd core
composer install
cp .env.example .env
php artisan key:generate
```

### 3. Database Configuration
Edit `core/.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cryptocoin_staking
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run Migrations & Seeders
```bash
php artisan migrate --seed
```

### 5. Staking Cron Configuration
Setup a cron job to trigger yield generation every 24 hours:
```bash
0 0 * * * curl -s https://yourdomain.com/cron/staking >/dev/null 2>&1
```

---

## 👨‍💻 Author
**Rana Umair Nawaz**  
- Founder, [ZedX Solutions](https://github.com/ranaumairnawaz)  
- [LinkedIn Profile](https://linkedin.com/in/ranaumairnawaz)  
- [Personal Portfolio](https://umair.zedx-solutions.com)
