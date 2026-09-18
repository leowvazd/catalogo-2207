import { Injectable, signal } from '@angular/core';
import { PaginatedResponse, ProductDetail, ProductListItem } from '../models/product';
import type { ProductFilters } from './product.service';

// Coloque em false quando a API estiver no ar, para que uma falha volte a mostrar o erro real.
export const DEMO_FALLBACK_ENABLED = true;

type Shape = 'bag' | 'pouch' | 'wallet';

const GOLD = '#a9814f';
const BLACK = '#26221e';
const BEIGE = '#cdb794';

function art(shape: Shape, body: string): string {
  const shapes: Record<Shape, string> = {
    bag:
      `<path d="M140 175C140 95 260 95 260 175" fill="none" stroke="${GOLD}" stroke-width="10" stroke-linecap="round"/>` +
      `<rect x="90" y="170" width="220" height="150" rx="24" fill="${body}"/>` +
      `<rect x="90" y="170" width="220" height="48" rx="24" fill="#000" opacity=".12"/>` +
      `<circle cx="200" cy="228" r="9" fill="${GOLD}"/>`,
    pouch:
      `<rect x="80" y="190" width="240" height="110" rx="40" fill="${body}"/>` +
      `<rect x="80" y="190" width="240" height="30" rx="15" fill="#000" opacity=".1"/>` +
      `<rect x="185" y="196" width="30" height="16" rx="4" fill="${GOLD}"/>`,
    wallet:
      `<rect x="110" y="150" width="180" height="120" rx="16" fill="${body}"/>` +
      `<path d="M110 185h180" stroke="#000" stroke-opacity=".18" stroke-width="4"/>` +
      `<circle cx="262" cy="222" r="8" fill="${GOLD}"/>`,
  };

  const svg =
    `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400">` +
    `<rect width="400" height="400" fill="#f6efe3"/>${shapes[shape]}</svg>`;

  return 'data:image/svg+xml;utf8,' + encodeURIComponent(svg);
}

const color = (option: string) => [{ name: 'Cor', option }];

const CATALOG: ProductDetail[] = [
  {
    id: 1,
    name: 'Bolsa Tote Clássica',
    slug: 'bolsa-tote-classica',
    brand: 'Lessenzza',
    description: 'Bolsa de couro sintético com alças reforçadas, ideal para o dia a dia.',
    variants: [
      { id: 1, sku: 'BTC-PRETA', price: 189.9, stock: 10, image: art('bag', BLACK), attributes: color('Preta') },
      { id: 2, sku: 'BTC-BEGE', price: 189.9, stock: 10, image: art('bag', BEIGE), attributes: color('Bege') },
    ],
  },
  {
    id: 2,
    name: 'Bolsa Transversal Mini',
    slug: 'bolsa-transversal-mini',
    brand: 'Lessenzza',
    description: 'Bolsa compacta e versátil, perfeita para sair sem carregar peso.',
    variants: [
      { id: 3, sku: 'BTM-PRETA', price: 129.9, stock: 10, image: art('bag', BLACK), attributes: color('Preta') },
    ],
  },
  {
    id: 3,
    name: 'Necessaire Premium',
    slug: 'necessaire-premium',
    brand: 'Lessenzza',
    description: 'Necessaire espaçosa com forro impermeável.',
    variants: [
      { id: 4, sku: 'NEC-BEGE', price: 59.9, stock: 10, image: art('pouch', BEIGE), attributes: color('Bege') },
    ],
  },
  {
    id: 4,
    name: 'Carteira Slim',
    slug: 'carteira-slim',
    brand: 'Lessenzza',
    description: 'Carteira slim com compartimentos para cartões e porta-moedas.',
    variants: [
      { id: 5, sku: 'CS-PRETA', price: 79.9, stock: 10, image: art('wallet', BLACK), attributes: color('Preta') },
    ],
  },
];

@Injectable({ providedIn: 'root' })
export class DemoService {
  readonly enabled = DEMO_FALLBACK_ENABLED;
  readonly active = signal(false);

  list(filters: ProductFilters = {}): PaginatedResponse<ProductListItem> {
    const search = (filters.search ?? '').toLowerCase().trim();
    const min = filters.min_price ?? null;
    const max = filters.max_price ?? null;

    let items = CATALOG.filter((p) => {
      const matchesSearch =
        !search || p.name.toLowerCase().includes(search) || (p.description ?? '').toLowerCase().includes(search);
      const matchesPrice = p.variants.some(
        (v) => (min === null || v.price >= Number(min)) && (max === null || v.price <= Number(max))
      );
      return matchesSearch && matchesPrice;
    }).map((p) => this.toListItem(p));

    const byPrice = (i: ProductListItem) => i.min_price ?? 0;
    switch (filters.sort) {
      case 'price_asc':
        items.sort((a, b) => byPrice(a) - byPrice(b));
        break;
      case 'price_desc':
        items.sort((a, b) => byPrice(b) - byPrice(a));
        break;
      case 'name_asc':
        items.sort((a, b) => a.name.localeCompare(b.name));
        break;
      case 'name_desc':
        items.sort((a, b) => b.name.localeCompare(a.name));
        break;
      case 'recent':
        items.sort((a, b) => b.id - a.id);
        break;
    }

    return {
      data: items,
      current_page: 1,
      last_page: 1,
      total: items.length,
      from: items.length ? 1 : null,
      to: items.length ? items.length : null,
    };
  }

  find(id: number): ProductDetail | undefined {
    return CATALOG.find((p) => p.id === id);
  }

  private toListItem(p: ProductDetail): ProductListItem {
    const prices = p.variants.map((v) => v.price);

    return {
      id: p.id,
      name: p.name,
      slug: p.slug,
      description: p.description,
      image: p.variants[0]?.image ?? null,
      variants_count: p.variants.length,
      single_variant_id: p.variants.length === 1 ? p.variants[0].id : null,
      min_price: Math.min(...prices),
      max_price: Math.max(...prices),
    };
  }
}
