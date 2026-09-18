import { Routes } from '@angular/router';
import { ProductListComponent } from './pages/product-list/product-list.component';
import { ProductDetailComponent } from './pages/product-detail/product-detail.component';
import { CartComponent } from './pages/cart/cart.component';
import { CheckoutComponent } from './pages/checkout/checkout.component';
import { OrderSuccessComponent } from './pages/order-success/order-success.component';

export const routes: Routes = [
  { path: '', component: ProductListComponent },
  { path: 'produto/:id', component: ProductDetailComponent },
  { path: 'carrinho', component: CartComponent },
  { path: 'finalizar', component: CheckoutComponent },
  { path: 'pedido/:id', component: OrderSuccessComponent },
  { path: '**', redirectTo: '' },
];
