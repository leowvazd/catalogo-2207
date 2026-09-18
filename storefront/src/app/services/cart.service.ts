import { Injectable, computed, inject, signal } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { tap } from 'rxjs';
import { Cart } from '../models/cart';

const TOKEN_KEY = 'lessenzza_cart_token';
const EMPTY_CART: Cart = { cart_token: null, items: [], total: 0 };

@Injectable({ providedIn: 'root' })
export class CartService {
  private http = inject(HttpClient);
  private base = '/api/cart';

  private state = signal<Cart>(EMPTY_CART);

  readonly cart = this.state.asReadonly();
  readonly itemCount = computed(() =>
    this.state().items.reduce((sum, item) => sum + item.quantity, 0)
  );

  constructor() {
    this.refresh();
  }

  private get token(): string | null {
    return localStorage.getItem(TOKEN_KEY);
  }

  private headers(): HttpHeaders {
    const token = this.token;
    return token ? new HttpHeaders({ 'X-Cart-Token': token }) : new HttpHeaders();
  }

  private persist(cart: Cart) {
    if (cart.cart_token) {
      localStorage.setItem(TOKEN_KEY, cart.cart_token);
    }
    this.state.set(cart);
  }

  refresh() {
    if (!this.token) {
      this.state.set(EMPTY_CART);
      return;
    }

    this.http.get<Cart>(this.base, { headers: this.headers() }).subscribe({
      next: (cart) => this.persist(cart),
      error: () => this.state.set(EMPTY_CART),
    });
  }

  add(variantId: number, quantity = 1) {
    return this.http
      .post<Cart>(`${this.base}/items/${variantId}`, { quantity }, { headers: this.headers() })
      .pipe(tap((cart) => this.persist(cart)));
  }

  update(variantId: number, quantity: number) {
    return this.http
      .put<Cart>(`${this.base}/items/${variantId}`, { quantity }, { headers: this.headers() })
      .pipe(tap((cart) => this.persist(cart)));
  }

  remove(variantId: number) {
    return this.http
      .delete<Cart>(`${this.base}/items/${variantId}`, { headers: this.headers() })
      .pipe(tap((cart) => this.persist(cart)));
  }

  clear() {
    return this.http
      .delete<Cart>(this.base, { headers: this.headers() })
      .pipe(tap((cart) => this.persist(cart)));
  }

  cartHeaders(): HttpHeaders {
    return this.headers();
  }
}
