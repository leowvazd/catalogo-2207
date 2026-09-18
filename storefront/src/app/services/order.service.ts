import { Injectable, inject } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, tap } from 'rxjs';
import { CheckoutPayload, Order } from '../models/cart';
import { CartService } from './cart.service';

@Injectable({ providedIn: 'root' })
export class OrderService {
  private http = inject(HttpClient);
  private cartService = inject(CartService);
  private base = '/api/orders';

  checkout(payload: CheckoutPayload): Observable<Order> {
    return this.http
      .post<Order>(this.base, payload, { headers: this.cartService.cartHeaders() })
      .pipe(tap(() => this.cartService.refresh()));
  }

  get(id: number): Observable<Order> {
    return this.http.get<Order>(`${this.base}/${id}`, { headers: this.cartService.cartHeaders() });
  }
}
