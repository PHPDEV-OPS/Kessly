# Contributing to Kessly

Thank you for your interest in contributing to Kessly! This document provides guidelines and steps for contributing to this project.

## Code of Conduct

By participating in this project, you agree to abide by our [Code of Conduct](CODE_OF_CONDUCT.md).

## Getting Started

### Prerequisites

- PHP 8.4 or higher
- Composer
- Node.js 20 LTS or higher
- npm

### Development Setup

1. **Fork the repository**
   - Click the "Fork" button at the top right of this repository

2. **Clone your fork**
   ```bash
   git clone https://github.com/YOUR_USERNAME/Kessly.git
   cd Kessly
   ```

3. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   ```

5. **Start development server**
   ```bash
   composer dev
   ```

## Making Changes

### Branch Naming Convention

- `feature/` - for new features (e.g., `feature/add-inventory-export`)
- `fix/` - for bug fixes (e.g., `fix/customer-search-error`)
- `docs/` - for documentation changes (e.g., `docs/update-readme`)
- `refactor/` - for code refactoring (e.g., `refactor/optimize-queries`)
- `test/` - for adding or updating tests (e.g., `test/add-sales-tests`)

### Commit Message Guidelines

We follow the [Conventional Commits](https://www.conventionalcommits.org/) specification:

- `feat:` - A new feature
- `fix:` - A bug fix
- `docs:` - Documentation only changes
- `style:` - Changes that don't affect the meaning of the code
- `refactor:` - A code change that neither fixes a bug nor adds a feature
- `perf:` - A code change that improves performance
- `test:` - Adding missing tests or correcting existing tests
- `chore:` - Changes to the build process or auxiliary tools

**Examples:**
```
feat: add customer export functionality
fix: resolve null pointer in inventory search
docs: update installation instructions
```

## Code Standards

### PHP

- Follow PSR-12 coding standards
- Use Laravel Pint for code formatting: `vendor/bin/pint`
- Write meaningful variable and function names
- Add PHPDoc comments for public methods

### JavaScript/CSS

- Use ES6+ syntax
- Follow Tailwind CSS conventions
- Keep components modular and reusable

### Testing

- Write tests for new features
- Ensure existing tests pass before submitting PR
- Run tests with: `composer test` or `vendor/bin/pest`

## Pull Request Process

1. **Create a branch** from `develop` for your changes
2. **Make your changes** and commit them with clear messages
3. **Run tests** to ensure nothing is broken: `composer test`
4. **Run linter** to ensure code style: `vendor/bin/pint`
5. **Push your branch** to your fork
6. **Create a Pull Request** against the `develop` branch
7. **Fill out the PR template** with all relevant information
8. **Wait for review** - maintainers will review your PR

### PR Checklist

- [ ] Code follows the project's coding standards
- [ ] Tests have been added/updated
- [ ] All tests pass locally
- [ ] Documentation has been updated if needed
- [ ] PR description clearly describes the changes

## Reporting Issues

### Bug Reports

When reporting bugs, please include:
- A clear description of the issue
- Steps to reproduce
- Expected vs actual behavior
- PHP and Laravel versions
- Screenshots if applicable

### Feature Requests

When suggesting features:
- Describe the problem you're trying to solve
- Explain your proposed solution
- Consider alternatives you've thought about

## Questions?

If you have questions, feel free to:
- Open a [Discussion](https://github.com/PHPDEV-OPS/Kessly/discussions)
- Review existing issues and PRs

Thank you for contributing to Kessly! 🍷
