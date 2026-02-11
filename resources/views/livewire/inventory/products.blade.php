<div
    x-data="{
        open: @entangle('showForm'),
        close() { this.open = false }
    }"
    x-on:keydown.escape.window="close()"
>
    <!-- Status Message -->
    @if (session()->has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="ri-checkbox-circle-line ri-20px me-2"></i>
                <span>{{ session('status') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search and Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label small text-muted">Search</label>
                    <input type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by name, SKU, description..."
                        class="form-control">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label small text-muted">Category</label>
                    <select wire:model.live="categoryFilter" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label small text-muted">Per Page</label>
                    <select wire:model.live="perPage" class="form-select">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

                <div class="col-12 col-md-4 text-md-end pt-2 pt-md-0">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <button type="button" class="btn btn-label-secondary flex-fill flex-md-grow-0" wire:click="export">
                            <i class="ri-download-line me-1"></i>
                            Export
                        </button>
                        <button type="button" class="btn btn-primary flex-fill flex-md-grow-0" wire:click="showAddProductModal">
                            <i class="ri-add-line me-1"></i>
                            Add Product
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="table-responsive">
        <table class="table table-hover table-stacked mb-0">
            <thead>
                <tr>
                    <th>
                        <button type="button"
                            class="btn btn-sm btn-link text-decoration-none p-0 d-flex align-items-center gap-1"
                            wire:click="sortBy('name')">
                            Product
                            @if ($sortField === 'name')
                                <i class="ri-{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}-s-line text-primary"></i>
                            @endif
                        </button>
                    </th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>
                        <button type="button"
                            class="btn btn-sm btn-link text-decoration-none p-0 d-flex align-items-center gap-1"
                            wire:click="sortBy('stock')">
                            Stock
                            @if ($sortField === 'stock')
                                <i class="ri-{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}-s-line text-primary"></i>
                            @endif
                        </button>
                    </th>
                    <th>
                        <button type="button"
                            class="btn btn-sm btn-link text-decoration-none p-0 d-flex align-items-center gap-1"
                            wire:click="sortBy('price')">
                            Price
                            @if ($sortField === 'price')
                                <i class="ri-{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}-s-line text-primary"></i>
                            @endif
                        </button>
                    </th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td data-label="Product">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="rounded">
                                    @else
                                        <span class="avatar-initial rounded bg-label-secondary">
                                            <i class="ri-product-hunt-line ri-20px"></i>
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $product->name }}</h6>
                                    @if ($product->description)
                                        <small class="text-muted">
                                            {{ \Illuminate\Support\Str::limit($product->description, 50) }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td data-label="Category">{{ $product->category?->name ?? '—' }}</td>
                        <td data-label="Supplier">{{ $product->supplier?->name ?? '—' }}</td>
                        <td data-label="Stock">
                            @if($product->stock === 0)
                                <span class="badge bg-label-danger">{{ $product->stock }}</span>
                            @elseif($product->stock <= 5)
                                <span class="badge bg-label-warning">{{ $product->stock }}</span>
                            @else
                                <span class="badge bg-label-success">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td data-label="Price" class="fw-medium">${{ number_format($product->price, 2) }}</td>
                        <td data-label="Actions" class="text-end">
                            <div class="d-flex justify-content-end justify-content-md-end gap-1 flex-wrap">
                                <button type="button"
                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                                    wire:click="edit({{ $product->id }})">
                                    <i class="ri-edit-line ri-20px"></i>
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-icon btn-text-danger rounded-pill"
                                    wire:click="delete({{ $product->id }})"
                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                    <i class="ri-delete-bin-line ri-20px"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <h6>No products found</h6>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="card-footer border-top">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>

    <!-- MODAL -->
    @if ($showForm)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form wire:submit.prevent="save">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="ri-{{ $productId ? 'edit' : 'add' }}-line me-2"></i>
                                {{ $productId ? 'Edit Product' : 'Add New Product' }}
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
                                        class="form-control @error('name') is-invalid @enderror"
                                        wire:model="name"
                                        placeholder="Enter product name"
                                    />
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <!-- Category and Supplier -->
                                <div class="col-md-6">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select
                                        id="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror"
                                        wire:model="category_id"
                                    >
                                        <option value="">Select category</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="supplier_id" class="form-label">Supplier</label>
                                    <select
                                        id="supplier_id"
                                        class="form-select @error('supplier_id') is-invalid @enderror"
                                        wire:model="supplier_id"
                                    >
                                        <option value="">No supplier</option>
                                        @foreach ($suppliers as $sup)
                                            <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <!-- Stock and Price -->
                                <div class="col-md-6">
                                    <label for="stock" class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                                    <input
                                        type="number"
                                        id="stock"
                                        min="0"
                                        class="form-control @error('stock') is-invalid @enderror"
                                        wire:model="stock"
                                        placeholder="0"
                                    />
                                    @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                                            class="form-control @error('price') is-invalid @enderror"
                                            wire:model="price"
                                            placeholder="0.00"
                                        />
                                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <!-- Description -->
                                <div class="col-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea
                                        id="description"
                                        rows="3"
                                        class="form-control @error('description') is-invalid @enderror"
                                        wire:model="description"
                                        placeholder="Enter product description (optional)"
                                    ></textarea>
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <!-- Image Upload -->
                                <div class="col-12">
                                    <label for="image" class="form-label">Product Image</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="flex-shrink-0">
                                            @if($image)
                                                <img class="rounded" style="width: 80px; height: 80px; object-fit: cover;" src="{{ $image->temporaryUrl() }}" alt="Preview">
                                            @elseif($productId && ($product = \App\Models\Product::find($productId)) && $product->image)
                                                <img class="rounded" style="width: 80px; height: 80px; object-fit: cover;" src="{{ asset('storage/' . $product->image) }}" alt="Current">
                                            @else
                                                <div class="avatar avatar-xl">
                                                    <span class="avatar-initial rounded bg-label-secondary">
                                                        <i class="ri-image-line ri-36px"></i>
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <input
                                                type="file"
                                                id="image"
                                                class="form-control @error('image') is-invalid @enderror"
                                                wire:model="image"
                                                accept="image/*"
                                            />
                                            <small class="text-muted">PNG, JPG, GIF up to 2MB</small>
                                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                                {{ $productId ? 'Update Product' : 'Create Product' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
