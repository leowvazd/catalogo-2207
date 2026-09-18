export interface CartItem {
  variant_id: number;
  product_name: string;
  sku: string;
  quantity: number;
  stock: number;
  unit_price: number;
  total: number;
  image: string | null;
}

export interface Cart {
  cart_token: string | null;
  items: CartItem[];
  total: number;
}

export interface OrderItem {
  product_name: string;
  variant_description: string;
  quantity: number;
  unit_price: number;
  total: number;
}

export interface Order {
  id: number;
  status: string;
  total: number;
  customer: {
    name: string;
    phone: string;
  };
  items: OrderItem[];
}

export interface CheckoutPayload {
  name: string;
  phone: string;
  email?: string;
  cnpjcpf?: string;
  address?: string;
  number?: string;
  city?: string;
  state?: string;
  postalcode?: string;
}
