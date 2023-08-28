import React from 'react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import FormInput from '@/Components/FormInput'
import Button from '@/Components/Button'
import { Head, useForm } from '@inertiajs/react'
import FormInputNumeric from '@/Components/FormInputNumeric'
import CustomerSelectionInput from '../Customer/SelectionInput'
import FormInputDate from '@/Components/FormInputDate'
import { formatIDR } from '@/utils'

export default function Form(props) {
    const { type, _now } = props

    const { data, setData, post, processing, errors } = useForm({
        customer_id: null,
        balance: null,
        amount: 0,
        date: _now,
        type: type,
    })

    const handleOnChange = (event) => {
        setData(
            event.target.name,
            event.target.type === 'checkbox'
                ? event.target.checked
                    ? 1
                    : 0
                : event.target.value
        )
    }

    const handleSubmit = () => {
        post(route('trx.store'))
    }

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={'Transaksi'}
            action={+type === 0 ? 'Setor' : 'Tarik'}
        >
            <Head title="Transaksi" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col">
                        <div className="text-xl font-bold mb-4">
                            Transaksi {+type === 0 ? 'Setor' : 'Tarik'}
                        </div>
                        <CustomerSelectionInput
                            placeholder="Input No.Rek / Nama"
                            itemSelected={data.customer_id}
                            onItemSelected={(item) => {
                                setData({
                                    ...data,
                                    customer_id: item?.id,
                                    balance: item?.balance,
                                })
                            }}
                            error={errors.customer_id}
                        />
                        {data.balance !== null && (
                            <div className="fond-bold mb-2">
                                Saldo: {formatIDR(data.balance)}
                            </div>
                        )}
                        <FormInputNumeric
                            name="amount"
                            value={data.amount}
                            onChange={handleOnChange}
                            label="Jumlah"
                            error={errors.amount}
                        />
                        <FormInputDate
                            name="Tanggal"
                            selected={data.date}
                            onChange={(date) => setData('date', date)}
                            label="Tanggal"
                            error={errors.date}
                        />
                        <div className="mt-2">
                            <Button
                                onClick={handleSubmit}
                                processing={processing}
                            >
                                Simpan
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
