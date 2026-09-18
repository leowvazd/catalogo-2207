export interface ProductListItem {
  id: number;
  name: string;
  slug: string;
  description: string | null;
  image: string | null;
  variants_count: number;
  single_variant_id: number | null;
  min_price: number | null;
  max_price: number | null;
}

export interface ProductVariantAttribute {
  name: string;
  option: string;
}

export interface ProductVariant {
  id: number;
  sku: string;
  price: number;
  stock: number;
  image: string | null;
  attributes: ProductVariantAttribute[];
}

export interface ProductDetail {
  id: number;
  name: string;
  slug: string;
  description: string | null;
  brand: string | null;
  variants: ProductVariant[];
}

export interface PaginatedResponse<T> {
  data: T[];
  current_page: number;
  last_page: number;
  total: number;
  from: number | null;
  to: number | null;
}
