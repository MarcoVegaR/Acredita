import { Users, ShieldCheck, Key, UserCheck } from 'lucide-react';
import AppLayout from '@/layouts/app-layout';
import { StatsCard } from '@/components/ui/stats-card/stats-card';
import { StatsCardGroup } from '@/components/ui/stats-card/stats-card-group';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { DataTable } from '@/components/ui/data-table/data-table';
import { useState } from 'react';

type RoleDistribution = {
    name: string;
    count: number;
    percentage: number;
};

type DashboardProps = {
    stats: {
        usuarios: {
            total: number;
            nuevos: number;
            crecimiento: number;
            tendencia: 'increase' | 'decrease' | 'neutral';
        };
        roles: {
            total: number;
            distribucion: RoleDistribution[];
        };
        permisos: {
            total: number;
        };
    };
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ stats }: DashboardProps) {
    const [roleColumns] = useState([
        {
            accessorKey: 'name',
            header: 'Rol',
        },
        {
            accessorKey: 'count',
            header: 'Usuarios',
        },
        {
            accessorKey: 'percentage',
            header: '% del Total',
            cell: ({ row }: { row: { getValue: (key: string) => number } }) => `${row.getValue('percentage')}%`,
        }
    ]);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-6 p-6">
                <div className="flex items-center justify-between">
                    <h1 className="text-3xl font-bold tracking-tight">Dashboard</h1>
                </div>

                <StatsCardGroup columns={4}>
                    <StatsCard
                        title="Usuarios Totales"
                        value={stats.usuarios.total}
                        icon={Users}
                        trend={{ 
                            value: stats.usuarios.crecimiento, 
                            type: stats.usuarios.tendencia 
                        }}
                        description={`${stats.usuarios.nuevos} nuevos este mes`}
                        variant="primary"
                    />
                    <StatsCard
                        title="Roles Totales"
                        value={stats.roles.total}
                        icon={ShieldCheck}
                        description="Roles del sistema"
                        variant="success"
                    />
                    <StatsCard
                        title="Permisos Totales"
                        value={stats.permisos.total}
                        icon={Key}
                        description="Permisos disponibles"
                        variant="warning"
                    />
                    <StatsCard
                        title="Usuarios con Rol"
                        value={stats.usuarios.total > 0 ? '100%' : '0%'}
                        icon={UserCheck}
                        description="Con al menos un rol asignado"
                        variant="primary"
                    />
                </StatsCardGroup>

                <div className="rounded-xl border p-4">
                    <h2 className="text-xl font-semibold mb-4">Distribución de Usuarios por Rol</h2>
                    <DataTable
                        columns={roleColumns}
                        data={stats.roles.distribucion}
                    />
                </div>
            </div>
        </AppLayout>
    );
}
