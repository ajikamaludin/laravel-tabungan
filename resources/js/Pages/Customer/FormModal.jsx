import React, { useEffect } from 'react'
import Modal from '@/Components/Modal'
import { useForm } from '@inertiajs/react'
import Button from '@/Components/Button'
import FormInput from '@/Components/FormInput'
import { isEmpty } from 'lodash'
import FormInputDate from '@/Components/FormInputDate'

export default function FormModal(props) {
    const { modalState } = props
    const { data, setData, post, put, processing, errors, reset, clearErrors } =
        useForm({
            name: '',
            class: '',
            dob: '',
            address: '',
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

    const handleReset = () => {
        modalState.setData(null)
        reset()
        clearErrors()
    }

    const handleClose = () => {
        handleReset()
        modalState.toggle()
    }

    const handleSubmit = () => {
        const customer = modalState.data
        if (customer !== null) {
            put(route('customer.update', customer), {
                onSuccess: () => handleClose(),
            })
            return
        }
        post(route('customer.store'), {
            onSuccess: () => handleClose(),
        })
    }

    useEffect(() => {
        const customer = modalState.data
        if (isEmpty(customer) === false) {
            setData({
                name: customer.name,
                class: customer.class,
                dob: customer.dob,
                address: customer.address,
            })
            return
        }
    }, [modalState])

    return (
        <Modal
            isOpen={modalState.isOpen}
            toggle={handleClose}
            title={'Pelanggan'}
        >
            <FormInput
                name="name"
                value={data.name}
                onChange={handleOnChange}
                label="Nama"
                error={errors.name}
            />
            <FormInput
                name="class"
                value={data.class}
                onChange={handleOnChange}
                label="Kelas"
                error={errors.class}
            />
            <FormInput
                name="address"
                value={data.address}
                onChange={handleOnChange}
                label="Alamat"
                error={errors.address}
            />
            <FormInputDate
                name="dob"
                selected={data.dob}
                onChange={date => setData('dob', date)}
                label="Tanggal Lahir"
                error={errors.dob}
            />
            <div className="flex items-center">
                <Button onClick={handleSubmit} processing={processing}>
                    Simpan
                </Button>
                <Button onClick={handleClose} type="secondary">
                    Batal
                </Button>
            </div>
        </Modal>
    )
}
