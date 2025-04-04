import { NextResponse } from 'next/server'
import type { NextRequest } from 'next/server'

// Rutas públicas que no requieren autenticación
const publicRoutes = ['/login', '/recuperar-contrasena', '/register']

// Rutas protegidas que requieren autenticación
const protectedRoutes = ['/intranet', '/intranet/usuarios', '/intranet/documentos']

export function middleware(request: NextRequest) {
  const token = request.cookies.get('token')?.value
  const { pathname } = request.nextUrl

  // Determinar si la ruta actual es pública
  const isPublicRoute = publicRoutes.includes(pathname)

  // Determinar si la ruta actual es protegida
  const isProtectedRoute = protectedRoutes.some(route => pathname.startsWith(route))

  // Si el usuario autenticado intenta acceder a una ruta pública, redirigir a /intranet
  if (isPublicRoute && token) {
    const response = NextResponse.redirect(new URL('/intranet', request.url))
    return response
  }

  // Si el usuario no está autenticado e intenta acceder a una ruta protegida, redirigir a /login
  if (isProtectedRoute && !token) {
    const response = NextResponse.redirect(new URL('/login', request.url))
    return response
  }

  // Para rutas protegidas, agregar el token a los headers
  if (isProtectedRoute && token) {
    const response = NextResponse.next()
    response.headers.set('Authorization', `Bearer ${token}`)
    response.headers.set('Access-Control-Allow-Credentials', 'true')
    return response
  }

  // Continuar con la solicitud normalmente
  return NextResponse.next()
}

export const config = {
  matcher: [
    '/login',
    '/register',
    '/recuperar-contrasena',
    '/intranet/:path*',
  ],
}
