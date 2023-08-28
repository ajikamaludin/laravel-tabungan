import React from 'react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { Head } from '@inertiajs/react'
import { formatIDR } from '@/utils'

export default function Dashboard(props) {
    const { customer_count, balance } = props
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={'Dashboard'}
            action={''}
        >
            <Head title="Dashboard" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8 grid grid-cols-4 gap-1">
                    <div className="overflow-hidden shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 px-6 py-4">
                        <div className="dark:text-gray-100 font-bold">
                            Jumlah Nasabah
                        </div>
                        <div className="dark:text-gray-100 text-2xl">
                            {formatIDR(customer_count)}
                        </div>
                    </div>
                    <div className="overflow-hidden shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 px-6 py-4">
                        <div className="dark:text-gray-100 font-bold">
                            Jumlah Saldo
                        </div>
                        <div className="dark:text-gray-100 text-2xl">
                            {formatIDR(balance)}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
