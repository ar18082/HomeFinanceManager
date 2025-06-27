# HomeManager – Documentation (EN)

## Overview

**HomeManager** is a Laravel application for personal finance and home energy management. It lets you manage accounts, budgets, transactions, credits, savings goals, and track energy meters (electricity, gas, water), readings, providers, and tariffs.

---

## Installation

1. **Clone the repository**
   ```bash
   git clone <repo-url>
   cd HomeFinanceManager-new
   ```
2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```
3. **Configure environment**
   - Copy `.env.example` to `.env`
   - Set your environment variables (DB, mail, etc.)
   - Generate app key:
     ```bash
     php artisan key:generate
     ```
4. **Create the database**
   - Create a MySQL/MariaDB database
   - Update `.env` with your DB credentials
5. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed --class=MegaEnergySeeder
   ```
6. **Build frontend assets**
   ```bash
   npm run build
   ```
7. **Start the server**
   ```bash
   php artisan serve
   ```
   Or use Laragon/XAMPP/Valet as you prefer.

---

## Main Features

- Manage accounts, categories, transactions, budgets, credits, savings goals
- Track energy meters (electricity, gas, water)
- Manage readings, consumption and cost calculations
- Manage energy providers, contracts, historical tariffs
- Notifications, reports, statistics

---

## Usage

1. **Register a user account**
2. **Add your bank accounts and categories**
3. **Enter your transactions and budgets**
4. **Add your energy meters** (electricity, gas, water)
5. **Enter your first readings**
6. **Configure your providers and tariffs**
7. **View reports and statistics**

---

## Usage Examples

### Tracking an Electricity Meter
1. Go to "Energy" → "Meters" → "Add Meter"
2. Fill in the details (name, type, number, unit, etc.)
3. Save
4. Go to "Energy" → "Add Reading" to enter a new reading
5. Costs and consumption are automatically calculated based on active tariffs

### Adding an Energy Provider
1. Go to "Energy" → "Providers" → "Add"
2. Enter the name, code, website, email, etc.
3. Add associated tariffs (electricity, gas, etc.)

### Analyzing a Consumption Report
1. Go to "Reports" → "Overview" or "Monthly"
2. Select the desired period
3. View the evolution of consumption and costs

---

## Use Cases

- **Multi-meter management**: Track several meters separately (e.g., house, garage, apartment)
- **Tariff history**: Automatic tariff changes based on validity dates
- **Alerts and notifications**: Reminders to enter a reading or pay a bill
- **Energy budgeting**: Compare energy expenses with your overall budget

---

## Best Practices

- Enter readings regularly for accurate tracking
- Update tariffs whenever your contract changes
- Use categories to organize your transactions
- Export reports for analysis or archiving

---

## Tips

- Customize units as needed (kWh, m³, etc.)
- Add notes to each meter or reading for contextual history
- Use savings goals to plan energy-related projects (e.g., buying a new appliance)
- Check statistics to spot unusual consumption

---

## Customization

- Logo: `public/img/logo.png`
- Views: `resources/views/`
- Tariff seeders: `database/seeders/`
- Add your own providers, tariffs, or customize the views as needed

---

## FAQ & Tips

**Q: How do I add a new energy provider?**
> Energy menu → Providers → Add

**Q: How do I edit a tariff?**
> Energy menu → Providers → Details → Edit tariff

**Q: Where can I find reports?**
> Reports menu (in the main navigation)

**Q: Can I customize categories or units?**
> Yes, everything is editable from the interface.

---

## Useful Links
- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com/)
- [Laravel Support](https://laracasts.com/)

---

**For any questions or contributions, open an issue or contact the project maintainer.** 