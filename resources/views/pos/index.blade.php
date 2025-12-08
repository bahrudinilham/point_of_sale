<x-app-layout>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .no-spinners::-webkit-inner-spin-button, 
        .no-spinners::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
        .no-spinners { -moz-appearance: textfield; }
    </style>

    <!-- Header Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-foreground">Point of Sale</h1>
                <p class="text-muted text-sm mt-1">Pilih produk dan proses transaksi penjualan</p>
            </div>
        </div>
    </div>

    <div class="pb-4" x-data="posSystem()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
                
                <!-- Product List -->
                <div class="lg:col-span-2 self-start">
                    <div class="bg-card shadow-xl sm:rounded-xl border border-border flex flex-col overflow-hidden">
                        <div class="p-4 sm:p-5 flex flex-col">
                            <!-- Search & Category Filter -->
                            <div class="mb-4 flex-shrink-0 space-y-3">
                                <!-- Search Input -->
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </div>
                                    <input type="text" x-model="searchQuery" @input.debounce.300ms="searchProducts()" placeholder="Cari produk..." class="w-full bg-background border-border text-foreground rounded-xl shadow-sm focus:border-[#5D5FEF] focus:ring-[#5D5FEF] py-3 pl-10 pr-4 transition-all duration-200">
                                </div>

                                <!-- Category Filter Tabs -->
                                <div id="categoryTabs" class="flex gap-2 overflow-x-auto no-scrollbar pb-1 cursor-grab active:cursor-grabbing">
                                    <button @click="selectedCategory = 'all'; filterByCategory()" 
                                            :class="selectedCategory === 'all' ? 'bg-[#5D5FEF] text-white border-[#5D5FEF]' : 'bg-background text-muted border-border hover:border-gray-400'"
                                            class="flex-shrink-0 px-4 py-2 rounded-lg border text-sm font-medium transition-all duration-200 whitespace-nowrap">
                                        Semua
                                    </button>
                                    @foreach($categories as $category)
                                        <button @click="selectedCategory = '{{ $category->id }}'; filterByCategory()" 
                                                :class="selectedCategory === '{{ $category->id }}' ? 'bg-[#5D5FEF] text-white border-[#5D5FEF]' : 'bg-background text-muted border-border hover:border-gray-400'"
                                                class="flex-shrink-0 px-4 py-2 rounded-lg border text-sm font-medium transition-all duration-200 whitespace-nowrap">
                                            {{ $category->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Products Grid Wrapper -->
                            <div class="flex-1 overflow-y-auto min-h-0 p-2 pb-14 lg:pb-4 custom-scrollbar relative">
                                <!-- Products Grid -->
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4 content-start">
                                    <template x-for="product in products" :key="product.id">
                                        <div @click="addToCart(product)" 
                                             class="bg-background p-3 sm:p-4 rounded-xl cursor-pointer border border-border hover:border-[#5D5FEF] hover:shadow-lg hover:shadow-indigo-500/10 hover:-translate-y-1 transition-all duration-200 h-[130px] sm:h-[140px] group relative hover:z-10">
                                            
                                            <!-- Hover Glow Effect -->
                                            <div class="absolute inset-0 bg-gradient-to-br from-[#5D5FEF]/0 to-[#5D5FEF]/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                                            
                                            <div class="relative z-10 h-full flex flex-col">
                                                <!-- Category Badge -->
                                                <span x-show="product.category" 
                                                      x-text="product.category?.name" 
                                                      class="inline-block self-start text-[10px] bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 px-1.5 py-0.5 rounded mb-1 font-medium"></span>
                                                
                                                <!-- Product Name -->
                                                <h3 class="font-medium text-foreground text-sm mb-1 line-clamp-2 group-hover:text-[#5D5FEF] transition-colors" x-text="product.name"></h3>
                                                
                                                <!-- Spacer to push content to bottom -->
                                                <div class="flex-1"></div>
                                                
                                                <!-- Price -->
                                                <p class="text-base sm:text-lg font-bold text-[#5D5FEF] mb-1" x-text="formatPrice(product.selling_price)"></p>
                                                
                                                <!-- Stock & Add Button Row -->
                                                <div class="flex justify-between items-center">
                                                    <p class="text-[10px] sm:text-xs font-medium" 
                                                       :class="product.stock <= 10 ? 'text-red-500' : 'text-muted'" 
                                                       x-text="product.stock <= 10 ? 'Sisa: ' + product.stock : 'Stok: ' + product.stock"></p>
                                                    
                                                    <div class="bg-card p-1.5 rounded-lg text-[#5D5FEF] opacity-0 group-hover:opacity-100 transform translate-y-1 group-hover:translate-y-0 transition-all duration-200 border border-border">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                
                                <!-- Empty State -->
                                <div x-show="products.length === 0 && !loading" class="text-center py-12">
                                    <div class="mx-auto w-16 h-16 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-foreground mb-1">Produk tidak ditemukan</h3>
                                    <p class="text-sm text-muted">Coba ubah kata kunci atau kategori</p>
                                </div>
                                
                                <!-- Loading Indicator -->
                                <div x-show="loading" class="absolute inset-0 flex items-center justify-center bg-background/50 z-20 backdrop-blur-sm">
                                    <svg class="animate-spin h-8 w-8 text-[#5D5FEF]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>

                                <!-- Pagination -->
                                <div class="mt-4 flex items-center justify-between flex-shrink-0 pt-2 border-t border-border sm:mb-0" x-show="pagination.last_page > 1">
                                    <!-- Mobile View -->
                                    <div class="flex justify-between items-center flex-1 sm:hidden">
                                        <button @click="goToPage(pagination.current_page - 1)" :disabled="pagination.current_page === 1" class="relative inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-[#5D5FEF] bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-900/30 rounded-lg hover:bg-[#5D5FEF] hover:text-white transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                        </button>
                                        
                                        <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                                            Hal <span class="text-foreground font-bold" x-text="pagination.current_page"></span> dari <span class="text-foreground font-bold" x-text="pagination.last_page"></span>
                                        </div>

                                        <button @click="goToPage(pagination.current_page + 1)" :disabled="pagination.current_page === pagination.last_page" class="relative inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-[#5D5FEF] bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-900/30 rounded-lg hover:bg-[#5D5FEF] hover:text-white transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </button>
                                    </div>

                                    <!-- Desktop View -->
                                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm text-muted">
                                                Menampilkan
                                                <span class="font-medium text-foreground" x-text="pagination.from"></span>
                                                -
                                                <span class="font-medium text-foreground" x-text="pagination.to"></span>
                                                dari
                                                <span class="font-medium text-foreground" x-text="pagination.total"></span>
                                                produk
                                            </p>
                                        </div>

                                        <div>
                                            <span class="flex items-center gap-2">
                                                <button @click="goToPage(pagination.current_page - 1)" :disabled="pagination.current_page === 1" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-muted bg-card border border-border rounded-lg hover:text-foreground hover:bg-background transition ease-in-out duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>

                                                <template x-for="(page, index) in paginationRange" :key="index">
                                                    <div class="inline-flex">
                                                        <button x-show="typeof page === 'number'"
                                                                @click="goToPage(page)" 
                                                                :class="page === pagination.current_page ? 'text-white bg-[#5D5FEF] border-[#5D5FEF] shadow-[0_0_15px_rgba(93,95,239,0.5)] font-bold' : 'text-muted bg-card border-border hover:text-foreground hover:bg-background font-medium'"
                                                                class="relative inline-flex items-center px-4 py-2 text-sm border rounded-lg transition ease-in-out duration-150"
                                                                x-text="page">
                                                        </button>
                                                        <span x-show="typeof page !== 'number'" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-muted">...</span>
                                                    </div>
                                                </template>

                                                <button @click="goToPage(pagination.current_page + 1)" :disabled="pagination.current_page === pagination.last_page" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-muted bg-card border border-border rounded-lg hover:text-foreground hover:bg-background transition ease-in-out duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart Section -->
                <div class="lg:col-span-1 h-full"
                     :class="{'fixed inset-0 z-50 flex flex-col justify-end': mobileCartOpen, 'hidden lg:block': !mobileCartOpen}">
                    
                    <!-- Mobile Backdrop -->
                    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm lg:hidden" 
                         x-show="mobileCartOpen" 
                         x-transition.opacity 
                         @click="mobileCartOpen = false"></div>

                    <div class="bg-card overflow-hidden shadow-xl sm:rounded-xl border border-border flex flex-col relative z-10 lg:z-auto lg:h-full w-full"
                         :class="{'h-[85vh] rounded-t-2xl': mobileCartOpen, 'h-full': !mobileCartOpen}"
                         :style="swipeOffset > 0 ? `transform: translateY(${swipeOffset}px)` : ''"
                         x-show="mobileCartOpen || window.innerWidth >= 1024"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="transform translate-y-full"
                         x-transition:enter-end="transform translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="transform translate-y-0"
                         x-transition:leave-end="transform translate-y-full">
                         
                        <!-- Drag Handle Area (Handle + Header) -->
                        <div class="flex-shrink-0 cursor-grab active:cursor-grabbing"
                             style="touch-action: none;"
                             @touchstart="touchStart($event)"
                             @touchmove.prevent="touchMove($event)"
                             @touchend="touchEnd($event)">
                            
                            <!-- Mobile Handle -->
                            <div class="lg:hidden flex justify-center items-center h-8" @click="mobileCartOpen = false">
                                <div class="w-12 h-1.5 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
                            </div>

                            <div class="px-4 sm:px-6 pb-2 pt-4 sm:pt-6 flex-1 flex flex-col min-h-0">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-bold text-foreground flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-[#5D5FEF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Keranjang
                                    </h3>
                                    <span x-show="cart.length > 0" class="text-xs bg-indigo-100 dark:bg-indigo-900/30 text-[#5D5FEF] px-2 py-0.5 rounded-full font-medium" x-text="totalQuantity + ' item'"></span>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 sm:px-6 flex-1 flex flex-col min-h-0">
                            
                            <!-- Cart Items -->
                            <div class="flex-1 overflow-y-auto no-scrollbar -mr-2 pr-2 pb-4 min-h-0 max-h-[calc(5*105px)]">
                                <template x-if="cart.length === 0">
                                    <div class="h-full flex flex-col items-center justify-center text-muted opacity-60 py-8">
                                        <div class="w-20 h-20 rounded-full bg-muted/10 flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        </div>
                                        <p class="font-medium text-foreground">Keranjang Kosong</p>
                                        <p class="text-xs mt-1">Pilih produk untuk memulai</p>
                                    </div>
                                </template>
                                <template x-for="(item, index) in cart" :key="item.id">
                                    <div :class="index === cart.length - 1 ? '' : 'mb-3'" class="flex justify-between items-center bg-background p-3 sm:p-4 rounded-xl border border-border group hover:border-gray-400 dark:hover:border-gray-600 transition-colors" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                                        <div class="flex-1 min-w-0 mr-3">
                                            <h4 class="font-semibold text-foreground text-sm line-clamp-1 mb-0.5" x-text="item.name"></h4>
                                            <p class="text-xs text-muted" x-text="formatPrice(item.price) + ' × ' + item.quantity"></p>
                                            <p class="text-sm font-bold text-[#5D5FEF] mt-0.5" x-text="formatPrice(item.price * item.quantity)"></p>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="flex items-center bg-card rounded-lg border border-border">
                                                <button @click="updateQuantity(index, item.quantity - 1)" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center text-muted hover:text-foreground hover:bg-background rounded-l-lg transition-colors font-bold">-</button>
                                                <input type="number" x-model="item.quantity" @change="updateQuantity(index, item.quantity)" class="w-8 sm:w-10 h-7 sm:h-8 text-center bg-transparent border-none text-foreground text-sm focus:ring-0 p-0 appearance-none">
                                                <button @click="updateQuantity(index, item.quantity + 1)" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center text-muted hover:text-foreground hover:bg-background rounded-r-lg transition-colors font-bold">+</button>
                                            </div>
                                            <button @click="removeFromCart(index)" class="ml-2 text-muted hover:text-red-500 transition-colors p-1 rounded-md hover:bg-red-500/10">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Footer Section (Totals & Checkout) -->
                            <div class="border-t border-border pt-4 pb-4 sm:pt-6 sm:pb-6 mt-auto flex-shrink-0">
                                <!-- Summary -->
                                <div class="mb-4">
                                    <div class="flex justify-between items-center text-sm text-muted mb-1">
                                        <span x-text="cart.length + ' produk (' + totalQuantity + ' item)'"></span>
                                    </div>
                                    <div class="flex justify-between items-end text-foreground">
                                        <span class="text-lg font-bold">Total</span>
                                        <span x-text="formatPrice(totalAmount)" class="text-2xl font-bold text-[#5D5FEF]"></span>
                                    </div>
                                </div>

                                <!-- Payment Method -->
                                <div class="mb-4" x-show="mode === 'physical'">
                                    <label class="block text-xs font-medium text-muted uppercase tracking-wider mb-2">Metode Pembayaran</label>
                                    <div class="flex gap-2 overflow-x-auto no-scrollbar pb-1 cursor-grab active:cursor-grabbing"
                                         x-data="{
                                            isDown: false,
                                            startX: 0,
                                            scrollLeft: 0,
                                            handleMouseDown(e) {
                                                this.isDown = true;
                                                this.startX = e.pageX - $el.offsetLeft;
                                                this.scrollLeft = $el.scrollLeft;
                                            },
                                            handleMouseLeave() { this.isDown = false; },
                                            handleMouseUp() { this.isDown = false; },
                                            handleMouseMove(e) {
                                                if (!this.isDown) return;
                                                e.preventDefault();
                                                const x = e.pageX - $el.offsetLeft;
                                                const walk = (x - this.startX) * 2; 
                                                $el.scrollLeft = this.scrollLeft - walk;
                                            },
                                            handleWheel(e) {
                                                if (e.deltaY !== 0) {
                                                    e.preventDefault();
                                                    $el.scrollLeft += e.deltaY;
                                                }
                                            }
                                         }"
                                         @mousedown="handleMouseDown"
                                         @mouseleave="handleMouseLeave"
                                         @mouseup="handleMouseUp"
                                         @mousemove="handleMouseMove"
                                         @wheel="handleWheel">
                                        @foreach($paymentMethods as $method)
                                            <button @click="paymentMethod = '{{ $method->id }}'"
                                                    :class="paymentMethod == '{{ $method->id }}' ? 'bg-[#5D5FEF] text-white border-[#5D5FEF]' : 'bg-background text-foreground border-border hover:border-gray-400'"
                                                    class="flex-shrink-0 px-4 py-2 rounded-lg border text-sm font-medium transition-all duration-200 whitespace-nowrap select-none">
                                                {{ $method->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                    <input type="hidden" x-model="paymentMethod">
                                </div>

                                <!-- Checkout Buttons -->
                                <div class="flex gap-2">
                                    <button @click="processCheckout()" 
                                            x-show="mode === 'physical'"
                                            :disabled="cart.length === 0 || processing"
                                            class="flex-1 bg-gradient-to-r from-[#5D5FEF] to-[#4b4ddb] hover:from-[#4b4ddb] hover:to-[#3a3bca] text-white font-bold py-3 sm:py-4 px-4 rounded-xl shadow-lg shadow-indigo-500/20 transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 flex justify-center items-center group">
                                        <span x-show="!processing" class="flex items-center text-base sm:text-lg">
                                            Bayar
                                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </span>
                                        <span x-show="processing" class="flex items-center">
                                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Memproses...
                                        </span>
                                    </button>

                                    <button @click="mode = 'digital'" 
                                            x-show="mode === 'physical'"
                                            class="bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-white border border-gray-200 dark:border-transparent font-bold py-3 sm:py-4 px-4 rounded-xl shadow-lg transition-all duration-200 transform hover:scale-[1.02] flex justify-center items-center"
                                            title="Top Up / Produk Digital">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Digital Checkout Form -->
                                <div x-show="mode === 'digital'" class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-medium text-muted uppercase tracking-wider mb-2">Nominal (Rp)</label>
                                        <input type="number" x-model="digitalForm.amount" class="no-spinners w-full bg-background border border-border text-foreground text-sm rounded-lg focus:ring-[#5D5FEF] focus:border-[#5D5FEF] block p-3" placeholder="Masukkan nominal">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-muted uppercase tracking-wider mb-2">Catatan (No. HP / ID)</label>
                                        <textarea x-model="digitalForm.note" rows="2" class="w-full bg-background border border-border text-foreground text-sm rounded-lg focus:ring-[#5D5FEF] focus:border-[#5D5FEF] block p-3" placeholder="Masukkan nomor HP atau ID"></textarea>
                                    </div>
                                    
                                    <div class="flex gap-2">
                                        <button @click="mode = 'physical'" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded-xl transition-all duration-200">
                                            Kembali
                                        </button>
                                        <button @click="processDigitalCheckout()" 
                                                :disabled="!digitalForm.amount || processing"
                                                class="flex-1 bg-gradient-to-r from-[#5D5FEF] to-[#4b4ddb] hover:from-[#4b4ddb] hover:to-[#3a3bca] text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-indigo-500/20 transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 flex justify-center items-center">
                                            <span x-show="!processing">Tambah ke Keranjang</span>
                                            <span x-show="processing" class="flex items-center">
                                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                Memproses...
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Sticky Cart Bar -->
        <div class="fixed bottom-0 left-0 right-0 bg-card border-t border-border p-4 lg:hidden z-40 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]" x-show="!mobileCartOpen" x-transition>
            <div class="flex justify-between items-center gap-4">
                <div>
                    <p class="text-xs text-muted" x-text="cart.length + ' produk'"></p>
                    <p class="text-lg font-bold text-[#5D5FEF]" x-text="formatPrice(totalAmount)"></p>
                </div>
                <button @click="mobileCartOpen = true" class="bg-[#5D5FEF] text-white px-6 py-2.5 rounded-lg font-bold shadow-lg shadow-indigo-500/30 flex items-center">
                    <span class="mr-2" x-text="totalQuantity + ' Item'"></span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        function posSystem() {
            return {
                products: @json($products->items()),
                pagination: {
                    current_page: {{ $products->currentPage() }},
                    last_page: {{ $products->lastPage() }},
                    total: {{ $products->total() }},
                    from: {{ $products->firstItem() ?? 0 }},
                    to: {{ $products->lastItem() ?? 0 }}
                },
                searchQuery: '',
                selectedCategory: 'all',
                cart: [],
                mobileCartOpen: false,
                paymentMethod: '{{ $paymentMethods->first()->id ?? "" }}',
                processing: false,
                loading: false,
                mode: 'physical',
                digitalForm: {
                    amount: '',
                    note: ''
                },
                touchStartY: 0,
                swipeOffset: 0,

                init() {
                    this.$watch('mobileCartOpen', value => {
                        if (value) {
                            document.body.classList.add('overflow-hidden');
                        } else {
                            document.body.classList.remove('overflow-hidden');
                            this.swipeOffset = 0;
                        }
                    });
                },

                touchStart(e) {
                    this.touchStartY = e.touches[0].clientY;
                    this.swipeOffset = 0;
                },

                touchMove(e) {
                    const currentY = e.touches[0].clientY;
                    const diff = currentY - this.touchStartY;
                    if (diff > 0) {
                        this.swipeOffset = diff;
                    }
                },

                touchEnd(e) {
                    if (this.swipeOffset > 100) {
                        this.mobileCartOpen = false;
                    }
                    this.swipeOffset = 0;
                    this.touchStartY = 0;
                },

                get totalAmount() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                },

                get totalQuantity() {
                    return this.cart.reduce((sum, item) => sum + item.quantity, 0);
                },

                get paginationRange() {
                    const current = parseInt(this.pagination.current_page);
                    const last = parseInt(this.pagination.last_page);
                    const range = [];
                    
                    if (last <= 5) {
                        for (let i = 1; i <= last; i++) range.push(i);
                        return range;
                    }
                    
                    range.push(1, 2, 3);
                    
                    if (current > 4) {
                        range.push('...');
                    }
                    
                    if (current > 3 && current < last) {
                        range.push(current);
                    }
                    
                    if (current < last - 1) {
                        range.push('...');
                    }
                    
                    range.push(last);
                    
                    return range;
                },

                goToPage(page) {
                    if (page < 1 || page > this.pagination.last_page || page === this.pagination.current_page) return;

                    this.loading = true;
                    const url = `{{ route("pos.search-products") }}?query=${this.searchQuery}&category_id=${this.selectedCategory}&page=${page}`;

                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            this.products = data.data;
                            this.pagination.current_page = data.current_page;
                            this.pagination.last_page = data.last_page;
                            this.pagination.total = data.total;
                            this.pagination.from = data.from;
                            this.pagination.to = data.to;
                            this.loading = false;
                        })
                        .catch(() => this.loading = false);
                },

                searchProducts() {
                    this.loading = true;
                    fetch(`{{ route("pos.search-products") }}?query=${this.searchQuery}&category_id=${this.selectedCategory}&page=1`)
                        .then(res => res.json())
                        .then(data => {
                            this.products = data.data;
                            this.pagination.current_page = data.current_page;
                            this.pagination.last_page = data.last_page;
                            this.pagination.total = data.total;
                            this.pagination.from = data.from;
                            this.pagination.to = data.to;
                            this.loading = false;
                        })
                        .catch(() => this.loading = false);
                },

                filterByCategory() {
                    this.searchProducts();
                },

                addToCart(product) {
                    const existingItem = this.cart.find(item => item.id === product.id);
                    
                    if (existingItem) {
                        if (existingItem.quantity < product.stock) {
                            existingItem.quantity++;
                        } else {
                            Swal.fire({ icon: 'error', title: 'Stok Habis', text: 'Stok tidak mencukupi!', timer: 1500, showConfirmButton: false });
                        }
                    } else {
                        this.cart.push({
                            id: product.id,
                            name: product.name,
                            price: product.selling_price,
                            quantity: 1,
                            stock: product.stock
                        });
                    }
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                },

                updateQuantity(index, quantity) {
                    if (quantity > this.cart[index].stock) {
                        Swal.fire({ icon: 'error', title: 'Stok Habis', text: 'Stok tidak mencukupi!', timer: 1500, showConfirmButton: false });
                        this.cart[index].quantity = this.cart[index].stock;
                    } else if (quantity < 1) {
                        this.cart[index].quantity = 1;
                    } else {
                        this.cart[index].quantity = quantity;
                    }
                },

                formatPrice(value) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
                },

                processCheckout() {
                    if (this.cart.length === 0) return;
                    
                    this.processing = true;

                    const itemsToProcess = this.cart.map(item => {
                        if (item.is_digital) {
                            const { id, ...rest } = item;
                            return rest;
                        }
                        return item;
                    });

                    fetch('{{ route("pos.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            items: itemsToProcess,
                            payment_method_id: this.paymentMethod
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.processing = false;
                        if (data.success) {
                            this.cart = [];
                            this.refreshProducts();
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Transaksi Berhasil!',
                                text: 'Pembayaran telah diproses.',
                                showCancelButton: true,
                                confirmButtonText: 'Cetak Struk',
                                cancelButtonText: 'Transaksi Baru',
                                confirmButtonColor: '#5D5FEF',
                                cancelButtonColor: '#6B7280',
                                reverseButtons: true
                            }).then((result) => {
                                if (data.low_stock_items && data.low_stock_items.length > 0) {
                                    let message = 'Produk berikut hampir habis:<br><ul class="text-left mt-2 text-sm">';
                                    data.low_stock_items.forEach(item => {
                                        message += `<li>• <b>${item.name}</b> (Sisa: ${item.stock})</li>`;
                                    });
                                    message += '</ul>';

                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Peringatan Stok Rendah',
                                        html: message,
                                        confirmButtonColor: '#F59E0B'
                                    }).then(() => {
                                        if (result.isConfirmed) {
                                            window.open(data.redirect_url, '_blank');
                                        }
                                    });
                                } else {
                                    if (result.isConfirmed) {
                                        window.open(data.redirect_url, '_blank');
                                    }
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: data.message,
                            });
                        }
                    })
                    .catch(error => {
                        this.processing = false;
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan.',
                        });
                        console.error(error);
                    });
                },

                processDigitalCheckout() {
                    if (!this.digitalForm.amount) return;
                    
                    this.cart.push({
                        id: 'digital-' + Date.now(),
                        name: 'Top Up: ' + (this.digitalForm.note || 'Tanpa Catatan'),
                        price: this.digitalForm.amount,
                        quantity: 1,
                        stock: 999999,
                        is_digital: true,
                        custom_price: this.digitalForm.amount,
                        note: this.digitalForm.note
                    });

                    this.digitalForm.amount = '';
                    this.digitalForm.note = '';
                    this.mode = 'physical';
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Ditambahkan',
                        text: 'Produk digital ditambahkan ke keranjang.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                },

                refreshProducts() {
                    this.loading = true;
                    const url = `{{ route("pos.search-products") }}?query=${this.searchQuery}&category_id=${this.selectedCategory}&page=${this.pagination.current_page}&_=${new Date().getTime()}`;
                    
                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            this.products = data.data;
                            this.pagination.current_page = data.current_page;
                            this.pagination.last_page = data.last_page;
                            this.pagination.total = data.total;
                            this.pagination.from = data.from;
                            this.pagination.to = data.to;
                            this.loading = false;
                        })
                        .catch(() => this.loading = false);
                }
            }
        }
    </script>
    
    <script>
        // Category tabs drag to scroll
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.getElementById('categoryTabs');
            if (!tabs) return;
            
            let isDown = false, startX, scrollLeft;
            
            tabs.addEventListener('mousedown', (e) => {
                isDown = true;
                tabs.style.cursor = 'grabbing';
                startX = e.pageX - tabs.offsetLeft;
                scrollLeft = tabs.scrollLeft;
            });
            
            tabs.addEventListener('mouseleave', () => {
                isDown = false;
                tabs.style.cursor = 'grab';
            });
            
            tabs.addEventListener('mouseup', () => {
                isDown = false;
                tabs.style.cursor = 'grab';
            });
            
            tabs.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - tabs.offsetLeft;
                const walk = (x - startX) * 2;
                tabs.scrollLeft = scrollLeft - walk;
            });
            
            // Mouse wheel horizontal scroll
            tabs.addEventListener('wheel', (e) => {
                if (e.deltaY !== 0) {
                    e.preventDefault();
                    tabs.scrollLeft += e.deltaY;
                }
            });
        });
    </script>
</x-app-layout>
