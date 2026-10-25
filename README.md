# 🪙 CryptoCoin Staking & Mining Platform

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel 11">
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php" alt="PHP 8.3">
  <img src="https://img.shields.io/badge/Staking%20Pools-Automated%20Yield-gold?style=for-the-badge" alt="Staking Yield">
  <img src="https://img.shields.io/badge/Crypto%20Gateways-Multi--Currency-blue?style=for-the-badge" alt="Crypto Gateways">
</p>

---

## 📖 What is CryptoCoin Staking & Mining Platform?

**CryptoCoin Staking & Mining Platform** is an institutional-grade **cryptocurrency yield-farming, decentralized token conversion, and cloud mining simulation platform** engineered with **Laravel 11, PHP 8.3, and MySQL**.

It enables digital asset holders to stake tokens into automated yield pools, swap currencies on an instant liquidity desk, participate in cloud mining contracts, and earn daily compounding interest calculated and credited automatically via scheduled background workers.

---

## 🎯 Why This Platform? Problem & Solution

| The Challenge | How This Platform Solves It |
| :--- | :--- |
| **Volatile, Manual Yield Distribution:** Managing thousands of staking contracts and calculating daily compounding interest manually is prone to human error. | Features an **Automated Staking Cron Engine** (`/cron/staking`) that runs daily at midnight to calculate and credit precise APY returns directly to user accounts. |
| **High Friction in Token Swapping:** Users typically have to exit to third-party exchanges to swap base currencies into staking tokens, leading to high network fees. | Provides a **Built-in Token Conversion Desk** (`ConversionController`) enabling instant zero-slippage swaps between fiat deposits and staking tokens. |
| **Asset Security & Fraud Risks:** Unregulated withdrawal requests and account takeovers threaten liquidity pools. | Implements **Mandatory KYC Verification**, Google Authenticator 2-Factor Authentication (2FA), and double-entry transaction ledgers with administrative review thresholds. |

---

## 🌟 Key Features

### 💎 Smart Staking & Yield Farming
- **Flexible & Locked Staking Tiers:** Deposit tokens into customizable pools with variable locking durations, daily interest rates, and capital return guarantees.
- **Automated Daily Compounding:** Background scheduler handles daily compounding and interest payouts without requiring manual claims.
- **Instant Token Swap Desk:** Swap easily between main wallet balances, platform tokens, and reward currencies.

### ⛏️ Cloud Mining & Earning Modules
- **Interactive Cloud Mining:** Simulated mining rigs with real-time hashrate displays, daily mining output quotas, and contract expiry rules.
- **PTC Advertisement Rewards:** Integrated ad-viewing earning module allowing users to supplement their staking yields.
- **Multi-Level Affiliate Matrix:** Tiered referral network paying recurring commissions on downline investments and staking payouts.

### 💳 Financial Gateways & Security
- **20+ Integrated Payment Channels:** Crypto-native gateways (BTCPayServer, CoinGate) and global fiat processors (Stripe, Razorpay, Mollie, Authorize.Net, Flutterwave).
- **KYC Documentation Management:** Upload identity documents, review proofs, and approve accounts within an intuitive admin pipeline.
- **Ledger Accounting:** Double-entry bookkeeping system guaranteeing balance accuracy across deposits, stakes, earnings, and withdrawals.

---

## 🛠️ Technical Stack

- **Framework:** Laravel 11.x, PHP 8.3
- **Database:** MySQL 8.0+ / MariaDB
- **Automation:** Scheduled Web Crons (`/cron/staking`), Laravel Queue Engine
- **Integrations:** BTCPayServer, CoinGate, Stripe, Twilio, SendGrid
- **Security:** Google 2FA, CSRF/XSS protection, prepared PDO transactions

---

## 📦 Local Installation & Setup

### 1. Requirements
- PHP 8.2 or 8.3 with `pdo_mysql`, `curl`, `fileinfo`, `gd`, `openssl`, `mbstring` extensions
- Composer 2.x
- MySQL 8.0+

### 2. Setup Application
```bash
git clone https://github.com/ranaumairnawaz/CryptoCoinStakingMiningPlatform.git
cd CryptoCoinStakingMiningPlatform

cd core
composer install
cp .env.example .env
php artisan key:generate
```

### 3. Database Migration & Launch
```bash
# In core/
php artisan migrate --seed
php artisan serve
```

### 4. Staking Cron Job
Configure your server to execute automated interest payouts every 24 hours:
```bash
0 0 * * * curl -s https://yourdomain.com/cron/staking >/dev/null 2>&1
```

---

## 👨‍💻 Author
**Rana Umair Nawaz**  
- [GitHub Profile](https://github.com/ranaumairnawaz)  
- [LinkedIn Profile](https://linkedin.com/in/ranaumairnawaz)
