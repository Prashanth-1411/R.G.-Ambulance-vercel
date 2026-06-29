# R.G. Ambulance Service

Emergency ambulance and funeral services provider operating pan India, headquartered in Chennai.

## Tech Stack

- React 19 + TypeScript 6 + Vite 8
- Tailwind CSS 3
- Framer Motion (minimal fade/slide animations)
- Lucide React (icons)
- React Router 7
- Nodemailer (contact form API)

## Project Structure

The Express API lives in the sibling `../backend/` folder (not inside `frontend/`).

```
frontend/
├── api/            # Serverless contact form handler (contact.mjs)
├── src/
│   ├── api/        # Frontend API client
│   ├── assets/     # Local image assets (1.jpg–8c.jpg)
│   ├── components/ # Shared UI components
│   ├── data/       # Service area data, testimonials, service listings
│   ├── pages/      # Route page components
│   └── main.tsx    # App entry point
└── vite.config.ts  # Proxies /api and /uploads to localhost:5000
```

Start the backend before dev (`cd ../backend && npm run dev`). See the root `README.md` for full setup.

## Service Areas

The project includes **111 location pages** across Chennai neighborhoods:
- **North Chennai (21):** Royapuram, George Town, Washermanpet, Tondiarpet, Vyasarpadi, Perambur, Otteri, Ayanavaram, Pulianthope, Sowcarpet, Parrys Corner, Broadway, Basin Bridge, Vallalar Nagar, Thiruvottiyur, Ennore, Manali, Madhavaram, Red Hills, Puzhal, Surapet
- **Central Chennai (30):** Egmore, Nungambakkam, Teynampet, Triplicane, Chepauk, Mylapore, Royapettah, Thousand Lights, Purasawalkam, Kellys, Choolai, Chintadripet, Shenoy Nagar, Arumbakkam, Aminijikarai, Koyambedu, Chetpet, Choolaimedu, Kodambakkam, Nandanam, Mambalam, West Mambalam, Vadapalani, Ashok Nagar, KK Nagar, Jafferkhanpet, Saligramam, Virugambakkam, Alwarthirunagar, Valasaravakkam, Anna Nagar, T Nagar, Kilpauk
- **West Chennai (25):** Porur, Ramapuram, Manapakkam, Mugalivakkam, Karambakkam, Poonamallee, Vanagaram, Maduravoyal, Nerkundram, Thirumazhisai, Ambattur, Mogappair, Iyyappanthangal, Mangadu, Kundrathur, Kovur, Gerugambakkam, Kolapakkam
- **South Chennai (20):** Saidapet, St Thomas Mount, Meenambakkam, Pallavaram, Chromepet, Selaiyur, Medavakkam, Madipakkam, Puzhuthivakkam, Nanmangalam, Kovilambakkam, Vengaivasal, Perumbakkam, Tambaram, OMR
- **OMR Corridor (10):** Sholinganallur, Semmancheri, Thoraipakkam, Perungudi, Karapakkam, Siruseri, Navalur, Kelambakkam, Adyar, Velachery
- **Coastal/South (7):** Besant Nagar, Thiruvanmiyur, Palavakkam, Neelankarai, Injambakkam, Kottivakkam, Uthandi
- **Tambaram Belt (10):** Tambaram Sanatorium, Tambaram West, Tambaram East, Anakaputhur, Pallikaranai, Sithalapakkam, Medavakkam (extended), Madipakkam (extended), Moovarasampettai, Vandalur

### Sitemap

Four sitemap files are maintained across the project:

| File | Purpose |
|------|---------|
| `frontend/public/sitemap.xml` | Vite source asset (auto-copied to dist on build) |
| `frontend/dist/sitemap.xml` | Vite build output |
| `public/frontend/sitemap.xml` | Laravel public copy |
| `public/sitemap.xml` | Apache doc root – served at `/sitemap.xml` |

All contain **111 location pages + 6 core pages** (home, ambulance-services, funeral-services, testimonials, blog, contact) with `https://www.rgambulanceservice.com/` as the base URL.

To submit to Google Search Console:
```
https://www.rgambulanceservice.com/sitemap.xml
```

### SEO Keywords

~333 total keywords distributed across 111 service areas (avg. 3 per location). Each location has a `meta_keywords` field in `src/data/service-areas.ts` targeting local search terms like:

- `ambulance [area name]`
- `emergency ambulance [area name]`
- `icu ambulance [area name]`
- `[area name] ambulance service`
- `[area name] local ambulance service`
- `emergency medical service [area name]`

## Available Scripts

```bash
npm run dev      # Start development server
npm run build    # TypeScript check + production build
npm run preview  # Preview production build
```

## Brand Colors

- **Royal Blue:** #0F4CFF
- **Medical Red:** #DC2626
- **Dark Slate:** #1E293B
- **White:** #FFFFFF

## Typography

- **Headings:** Inter
- **Body:** Poppins
- **Accent:** Nunito Sans
