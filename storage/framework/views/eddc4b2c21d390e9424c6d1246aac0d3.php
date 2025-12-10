<div>
    <!-- Status Message -->
    <!--[if BLOCK]><![endif]--><?php if(session()->has('status')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="ri-checkbox-circle-line ri-20px me-2"></i>
                <span><?php echo e(session('status')); ?></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Search and Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small text-muted">Search</label>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name, SKU, description..." class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Category</label>
                    <select wire:model.live="categoryFilter" class="form-select">
                        <option value="">All Categories</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Per Page</label>
                    <select wire:model.live="perPage" class="form-select">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-label-secondary" wire:click="export">
                        <i class="ri-download-line me-1"></i>
                        Export
                    </button>
                    <button type="button" class="btn btn-primary" wire:click="create">
                        <i class="ri-add-line me-1"></i>
                        Add Product
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>
                            <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 d-flex align-items-center gap-1" wire:click="sortBy('name')">
                                Product
                                <!--[if BLOCK]><![endif]--><?php if($sortField === 'name'): ?>
                                    <i class="ri-<?php echo e($sortDirection === 'asc' ? 'arrow-up' : 'arrow-down'); ?>-s-line text-primary"></i>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </button>
                        </th>
                        <th>Category</th>
                        <th>Supplier</th>
                        <th>
                            <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 d-flex align-items-center gap-1" wire:click="sortBy('stock')">
                                Stock
                                <!--[if BLOCK]><![endif]--><?php if($sortField === 'stock'): ?>
                                    <i class="ri-<?php echo e($sortDirection === 'asc' ? 'arrow-up' : 'arrow-down'); ?>-s-line text-primary"></i>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </button>
                        </th>
                        <th>
                            <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 d-flex align-items-center gap-1" wire:click="sortBy('price')">
                                Price
                                <!--[if BLOCK]><![endif]--><?php if($sortField === 'price'): ?>
                                    <i class="ri-<?php echo e($sortDirection === 'asc' ? 'arrow-up' : 'arrow-down'); ?>-s-line text-primary"></i>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </button>
                        </th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <!--[if BLOCK]><![endif]--><?php if($product->image): ?>
                                            <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" class="rounded">
                                        <?php else: ?>
                                            <span class="avatar-initial rounded bg-label-secondary">
                                                <i class="ri-product-hunt-line ri-20px"></i>
                                            </span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div>
                                        <h6 class="mb-0"><?php echo e($product->name); ?></h6>
                                        <!--[if BLOCK]><![endif]--><?php if($product->description): ?>
                                            <small class="text-muted"><?php echo e(\Illuminate\Support\Str::limit($product->description, 50)); ?></small>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            </td>
                            <td><?php echo e($product->category?->name ?? '—'); ?></td>
                            <td><?php echo e($product->supplier?->name ?? '—'); ?></td>
                            <td>
                                <!--[if BLOCK]><![endif]--><?php if($product->stock === 0): ?>
                                    <span class="badge bg-label-danger"><?php echo e($product->stock); ?></span>
                                <?php elseif($product->stock <= 5): ?>
                                    <span class="badge bg-label-warning"><?php echo e($product->stock); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-label-success"><?php echo e($product->stock); ?></span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>
                            <td class="fw-medium">$<?php echo e(number_format($product->price, 2)); ?></td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill" wire:click="edit(<?php echo e($product->id); ?>)" title="Edit">
                                        <i class="ri-edit-line ri-20px"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-icon btn-text-danger rounded-pill" wire:click="delete(<?php echo e($product->id); ?>)" onclick="return confirm('Are you sure you want to delete this product?')" title="Delete">
                                        <i class="ri-delete-bin-line ri-20px"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="avatar avatar-xl mb-3">
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            <i class="ri-shopping-bag-3-line ri-48px"></i>
                                        </span>
                                    </div>
                                    <h6 class="mb-1">No products found</h6>
                                    <p class="text-muted small mb-0">Get started by adding your first product.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
    </div>

    <!-- Pagination and Stats -->
    <div class="card-footer border-top">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <small class="text-muted">
                        <i class="ri-information-line me-1"></i>
                        Showing <?php echo e($products->firstItem() ?? 0); ?> to <?php echo e($products->lastItem() ?? 0); ?> of <?php echo e($products->total()); ?> products
                    </small>
                </div>
                <!--[if BLOCK]><![endif]--><?php if($products->hasPages()): ?>
                    <nav aria-label="Product pagination">
                        <?php echo e($products->links('pagination::bootstrap-5')); ?>

                    </nav>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
    </div>
    
    <style>
        .pagination {
            margin: 0;
            gap: 0.25rem;
            }
            .pagination .page-link {
                border-radius: 0.375rem;
                border: 1px solid #ddd;
                color: #697a8d;
                padding: 0.375rem 0.75rem;
                margin: 0 2px;
                font-size: 0.9375rem;
                transition: all 0.2s;
            }
            .pagination .page-link svg {
                display: none;
            }
            .pagination .page-link:hover {
                background-color: #f5f5f9;
                border-color: #7367f0;
                color: #7367f0;
            }
            .pagination .page-item.active .page-link {
                background-color: #7367f0;
                border-color: #7367f0;
                color: #fff;
            }
            .pagination .page-item.disabled .page-link {
                background-color: #f5f5f9;
                border-color: #ddd;
                color: #c7cdd4;
                cursor: not-allowed;
            }
        </style>
    </div>

    <!-- Create/Edit Form Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showForm): ?>
        <div class="modal-backdrop fade show" style="z-index: 1050;"></div>
        <div class="modal fade show d-block" tabindex="-1" style="z-index: 1055; position: fixed; top: 0; left: 0; width: 100%; height: 100%;">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form wire:submit.prevent="save">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="ri-<?php echo e($productId ? 'edit' : 'add'); ?>-line me-2"></i>
                                <?php echo e($productId ? 'Edit Product' : 'Add New Product'); ?>

                            </h5>
                            <button type="button" class="btn-close" wire:click="cancel" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <!-- Name -->
                                <div class="col-12">
                                    <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        id="name"
                                        class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        wire:model="name"
                                        placeholder="Enter product name"
                                    />
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <!-- Category and Supplier -->
                                <div class="col-md-6">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select
                                        id="category_id"
                                        class="form-select <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        wire:model="category_id"
                                    >
                                        <option value="">Select category</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div class="col-md-6">
                                    <label for="supplier_id" class="form-label">Supplier</label>
                                    <select
                                        id="supplier_id"
                                        class="form-select <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        wire:model="supplier_id"
                                    >
                                        <option value="">No supplier</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sup->id); ?>"><?php echo e($sup->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <!-- Stock and Price -->
                                <div class="col-md-6">
                                    <label for="stock" class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                                    <input
                                        type="number"
                                        id="stock"
                                        min="0"
                                        class="form-control <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        wire:model="stock"
                                        placeholder="0"
                                    />
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div class="col-md-6">
                                    <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input
                                            type="number"
                                            id="price"
                                            step="0.01"
                                            min="0"
                                            class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            wire:model="price"
                                            placeholder="0.00"
                                        />
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea
                                        id="description"
                                        rows="3"
                                        class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        wire:model="description"
                                        placeholder="Enter product description (optional)"
                                    ></textarea>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <!-- Image Upload -->
                                <div class="col-12">
                                    <label for="image" class="form-label">Product Image</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="flex-shrink-0">
                                            <!--[if BLOCK]><![endif]--><?php if($image): ?>
                                                <img class="rounded" style="width: 80px; height: 80px; object-fit: cover;" src="<?php echo e($image->temporaryUrl()); ?>" alt="Preview">
                                            <?php elseif($productId && ($product = \App\Models\Product::find($productId)) && $product->image): ?>
                                                <img class="rounded" style="width: 80px; height: 80px; object-fit: cover;" src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="Current">
                                            <?php else: ?>
                                                <div class="avatar avatar-xl">
                                                    <span class="avatar-initial rounded bg-label-secondary">
                                                        <i class="ri-image-line ri-36px"></i>
                                                    </span>
                                                </div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <div class="flex-grow-1">
                                            <input
                                                type="file"
                                                id="image"
                                                class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                wire:model="image"
                                                accept="image/*"
                                            />
                                            <small class="text-muted">PNG, JPG, GIF up to 2MB</small>
                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-label-secondary" wire:click="cancel">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i>
                                <?php echo e($productId ? 'Update Product' : 'Create Product'); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH D:\School-Projects\Software-dev\Kessly\resources\views/livewire/inventory/products.blade.php ENDPATH**/ ?>