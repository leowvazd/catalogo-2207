import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';
import { PaginatedResponse, ProductDetail, ProductListItem } from '../models/product';

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
  private base = '/api/products';

  list(filters: ProductFilters = {}): Observable<PaginatedResponse<ProductListItem>> {
    let params = new HttpParams();

    Object.entries(filters).forEach(([key, value]) => {
      if (value !== undefined && value !== null && value !== '') {
        params = params.set(key, String(value));
      }
    });

    return this.http.get<PaginatedResponse<ProductListItem>>(this.base, { params });
  }

  get(id: number): Observable<ProductDetail> {
    return this.http.get<ProductDetail>(`${this.base}/${id}`);
  }
}
