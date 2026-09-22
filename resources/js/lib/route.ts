/**
 * Lightweight application route resolver for single-admin portfolio.
 */
type RouteParam = string | number | Record<string, any> | undefined;

const routes: Record<string, string | ((param?: any) => string)> = {
    home: '/',
    'portfolio.contact': '/contact',
    dashboard: '/dashboard',
    login: '/login',
    'login.store': '/login',
    logout: '/logout',
    'access-gate.show': '/gate',
    'access-gate.verify': '/gate/verify',
    'access-gate.forgot': '/gate/forgot',
    'access-gate.reset': (param?: RouteParam) => {
        const token =
            typeof param === 'object' && param !== null
                ? (param.token ?? '')
                : (param ?? '');
        return `/gate/reset/${token}`;
    },
    'access-gate.update': '/gate/reset',
    'admin.dashboard': '/admin',
    'admin.profile.edit': '/admin/profile',
    'admin.profile.update': '/admin/profile',
    'admin.projects.index': '/admin/projects',
    'admin.projects.store': '/admin/projects',
    'admin.projects.update': (param?: RouteParam) => {
        const id =
            typeof param === 'object' && param !== null
                ? (param.id ?? param.project)
                : param;
        return `/admin/projects/${id}`;
    },
    'admin.projects.destroy': (param?: RouteParam) => {
        const id =
            typeof param === 'object' && param !== null
                ? (param.id ?? param.project)
                : param;
        return `/admin/projects/${id}`;
    },
    'admin.skills.index': '/admin/skills',
    'admin.skills.store': '/admin/skills',
    'admin.skills.update': (param?: RouteParam) => {
        const id =
            typeof param === 'object' && param !== null
                ? (param.id ?? param.skill)
                : param;
        return `/admin/skills/${id}`;
    },
    'admin.skills.destroy': (param?: RouteParam) => {
        const id =
            typeof param === 'object' && param !== null
                ? (param.id ?? param.skill)
                : param;
        return `/admin/skills/${id}`;
    },
    'admin.experiences.index': '/admin/experiences',
    'admin.experiences.store': '/admin/experiences',
    'admin.experiences.update': (param?: RouteParam) => {
        const id =
            typeof param === 'object' && param !== null
                ? (param.id ?? param.experience)
                : param;
        return `/admin/experiences/${id}`;
    },
    'admin.experiences.destroy': (param?: RouteParam) => {
        const id =
            typeof param === 'object' && param !== null
                ? (param.id ?? param.experience)
                : param;
        return `/admin/experiences/${id}`;
    },
    'admin.messages.index': '/admin/messages',
    'admin.messages.read': (param?: RouteParam) => {
        const id =
            typeof param === 'object' && param !== null
                ? (param.id ?? param.message)
                : param;
        return `/admin/messages/${id}/read`;
    },
    'admin.messages.destroy': (param?: RouteParam) => {
        const id =
            typeof param === 'object' && param !== null
                ? (param.id ?? param.message)
                : param;
        return `/admin/messages/${id}`;
    },
    'admin.access-code.edit': '/admin/security/access-code',
    'admin.access-code.update': '/admin/security/access-code',
};

export function route(name?: string, param?: RouteParam): string {
    if (!name) {
        return window.location.pathname;
    }

    const target = routes[name];

    if (!target) {
        console.warn(`Route [${name}] not found in route definition table.`);
        return `/${name.replace(/\./g, '/')}`;
    }

    if (typeof target === 'function') {
        return target(param);
    }

    return target;
}

export default route;
