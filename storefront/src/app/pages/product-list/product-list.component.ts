import { Component, OnInit, inject, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { RouterLink } from '@angular/router';
import { ProductService } from '../../services/product.service';
import { CartService } from '../../services/cart.service';
import { PaginatedResponse, ProductListItem } from '../../models/product';

@Component({
  selector: 'app-product-list',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterLink],
  templateUrl: './product-list.component.html',
})
export class ProductListComponent implements OnInit {
  private productService = inject(ProductService);
  private cartService = inject(CartService);

  response = signal<PaginatedResponse<ProductListItem> | null>(null);
  loading = signal(true);

  search = '';
  sort = '';
  minPrice: number | null = null;
  maxPrice: number | null = null;
  page = 1;

  ngOnInit() {
    this.load();
  }

  load() {
    this.loading.set(true);

    this.productService
      .list({
        search: this.search,
        sort: this.sort,
        min_price: this.minPrice ?? undefined,
        max_price: this.maxPrice ?? undefined,
        page: this.page,
      })
      .subscribe({
        next: (res) => {
          this.response.set(res);
          this.loading.set(false);
        },
        error: () => this.loading.set(false),
      });
  }

  onSearch() {
    this.page = 1;
    this.load();
  }

  onSortChange() {
    this.page = 1;
    this.load();
  }

  clearFilters() {
    this.search = '';
    this.sort = '';
    this.minPrice = null;
    this.maxPrice = null;
    this.page = 1;
    this.load();
  }

  goToPage(page: number) {
    if (page < 1 || (this.response() && page > this.response()!.last_page)) {
      return;
    }
    this.page = page;
    this.load();
  }

  addToCart(variantId: number) {
    this.cartService.add(variantId, 1).subscribe();
  }

  formatPrice(value: number | null): string {
    if (value === null) return '-';
    return value.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }
}
