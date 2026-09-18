import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, catchError, of, tap, throwError } from 'rxjs';
import { PaginatedResponse, ProductDetail, ProductListItem } from '../models/product';
import { DemoService } from './demo.service';

export interface ProductFilters {
  search?: string;
  sort?: string;
  min_price?: number;
  max_price?: number;
  page?: number;
}

@Injectable({ providedIn: 'root' })
export class ProductService {
  private http = inject(HttpClient);
  private demo = inject(DemoService);
  private base = '/api/products';

  list(filters: ProductFilters = {}): Observable<PaginatedResponse<ProductListItem>> {
    let params = new HttpParams();

    Object.entries(filters).forEach(([key, value]) => {
      if (value !== undefined && value !== null && value !== '') {
        params = params.set(key, String(value));
      }
    });

    return this.http.get<PaginatedResponse<ProductListItem>>(this.base, { params }).pipe(
      tap(() => this.demo.active.set(false)),
      catchError((err) => {
        if (!this.demo.enabled) {
          return throwError(() => err);
        }
        this.demo.active.set(true);
        return of(this.demo.list(filters));
      })
    );
  }

  get(id: number): Observable<ProductDetail> {
    return this.http.get<ProductDetail>(`${this.base}/${id}`).pipe(
      tap(() => this.demo.active.set(false)),
      catchError((err) => {
        const product = this.demo.enabled ? this.demo.find(id) : undefined;
        if (!product) {
          return throwError(() => err);
        }
        this.demo.active.set(true);
        return of(product);
      })
    );
  }
}
