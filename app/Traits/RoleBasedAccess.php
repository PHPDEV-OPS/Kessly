<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait RoleBasedAccess
{
    /**
     * Scope to filter records based on user role and ownership
     */
    public function scopeForUser(Builder $query, $user = null): Builder
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return $query->whereRaw('1 = 0'); // Return no results if no user
        }

        // Administrators see everything
        if ($user->hasRole('Administrator') || $user->hasRole('Super Admin')) {
            return $query;
        }

        // If user has no role assigned, return all data (temporary solution for testing)
        if (!$user->role) {
            return $query;
        }

        $userRole = $user->role->name;

        switch ($userRole) {
            case 'Branch Manager':
                return $this->scopeForBranchManager($query, $user);

            case 'Sales Manager':
                return $this->scopeForSalesManager($query, $user);

            case 'Inventory Manager':
                return $this->scopeForInventoryManager($query, $user);

            case 'Accountant':
                return $this->scopeForAccountant($query, $user);

            case 'HR Manager':
                return $this->scopeForHRManager($query, $user);

            case 'Sales Representative':
                return $this->scopeForSalesRepresentative($query, $user);

            case 'Customer Service':
                return $this->scopeForCustomerService($query, $user);

            case 'Warehouse Supervisor':
                return $this->scopeForWarehouseSupervisor($query, $user);

            default:
                // For other roles, return no data or limited data
                return $query->whereRaw('1 = 0');
        }
    }

    /**
     * Branch Manager can only see their branch data
     */
    protected function scopeForBranchManager(Builder $query, $user): Builder
    {
        $branch = $user->getBranch();

        if ($this instanceof \App\Models\Branch) {
            return $query->where('id', $branch?->id);
        }

        if ($this instanceof \App\Models\Employee) {
            return $query->where('branch_id', $branch?->id);
        }

        if ($this instanceof \App\Models\Order) {
            return $query->where('branch_id', $branch?->id);
        }

        if ($this instanceof \App\Models\BranchInventory) {
            return $query->where('branch_id', $branch?->id);
        }

        // For other models, return all if no specific filtering needed
        return $query;
    }

    /**
     * Sales Manager can see sales-related data
     */
    protected function scopeForSalesManager(Builder $query, $user): Builder
    {
        if ($this instanceof \App\Models\Order) {
            // Sales managers can see all orders
            return $query;
        }

        if ($this instanceof \App\Models\Customer) {
            // Sales managers can see all customers
            return $query;
        }

        if ($this instanceof \App\Models\User && $user->role?->name === 'Sales Representative') {
            // Can see sales representatives under them
            return $query->whereHas('role', function($q) {
                $q->where('name', 'Sales Representative');
            });
        }

        return $query;
    }

    /**
     * Inventory Manager can only see inventory-related data
     */
    protected function scopeForInventoryManager(Builder $query, $user): Builder
    {
        if ($this instanceof \App\Models\Product) {
            return $query; // Can see all products
        }

        if ($this instanceof \App\Models\BranchInventory) {
            return $query; // Can see all branch inventories
        }

        if ($this instanceof \App\Models\Category) {
            return $query; // Can see all categories
        }

        // For other models, restrict access
        return $query->whereRaw('1 = 0');
    }

    /**
     * Accountant can only see finance-related data
     */
    protected function scopeForAccountant(Builder $query, $user): Builder
    {
        if ($this instanceof \App\Models\Invoice) {
            return $query; // Can see all invoices
        }

        if ($this instanceof \App\Models\Expense) {
            return $query; // Can see all expenses
        }

        if ($this instanceof \App\Models\Order) {
            // Can see orders for financial reporting
            return $query;
        }

        if ($this instanceof \App\Models\Product) {
             return $query;
        }

        // For other models, restrict access
        return $query->whereRaw('1 = 0');
    }

    /**
     * HR Manager can only see HR-related data
     */
    protected function scopeForHRManager(Builder $query, $user): Builder
    {
        if ($this instanceof \App\Models\Employee) {
            return $query; // Can see all employees
        }

        if ($this instanceof \App\Models\User) {
            return $query; // Can see all users for HR purposes
        }

        if ($this instanceof \App\Models\Payroll) {
            return $query; // Can see all payroll data
        }

        // For other models, restrict access
        return $query->whereRaw('1 = 0');
    }

    /**
     * Sales Representative can only see their own data
     */
    protected function scopeForSalesRepresentative(Builder $query, $user): Builder
    {
        if ($this instanceof \App\Models\Product) {
            return $query; // Can see products to sell them
        }
        
        if ($this instanceof \App\Models\Category) {
            return $query;
        }

        if ($this instanceof \App\Models\Order) {
            // Can see orders they created OR orders assigned to their branch
            $branch = $user->getBranch();
            return $query->where(function($q) use ($user, $branch) {
                $q->where('created_by', $user->id);
                if ($branch) {
                    $q->orWhere('branch_id', $branch->id);
                }
            });
        }

        if ($this instanceof \App\Models\Customer) {
            // Can see customers they created or assigned to them
            return $query->where('created_by', $user->id);
        }

        return $query->whereRaw('1 = 0');
    }

    /**
     * Customer Service can see customer-related data
     */
    protected function scopeForCustomerService(Builder $query, $user): Builder
    {
        if ($this instanceof \App\Models\Customer) {
            return $query; // Can see all customers
        }

        if ($this instanceof \App\Models\Order) {
            // Can see orders for customer service
            return $query;
        }

        return $query->whereRaw('1 = 0');
    }

    /**
     * Warehouse Supervisor can see warehouse/inventory data
     */
    protected function scopeForWarehouseSupervisor(Builder $query, $user): Builder
    {
        if ($this instanceof \App\Models\BranchInventory) {
            return $query; // Can see all branch inventories
        }

        if ($this instanceof \App\Models\Product) {
            return $query; // Can see all products
        }

        return $query->whereRaw('1 = 0');
    }
}