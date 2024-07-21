import { DataTable } from 'primereact/datatable';
import { Column } from 'primereact/column';
import { useQuery, useQueryClient } from '@tanstack/react-query';
import { useCallback, useEffect, useRef, useState } from 'preact/hooks'
import { Tag } from 'primereact/tag'
import { Button } from 'primereact/button';
import { InputText } from 'primereact/inputtext';
import { Dropdown } from 'primereact/dropdown';
import { Toast } from 'primereact/toast';
import { Calendar } from 'primereact/calendar';

import dayjs from "dayjs"

const getSeverity = (status) => {
    switch (status) {
        case false:
            return 'danger';

        case true:
            return 'success';

        case 'Off':
            return 'danger';

        case 'On':
            return 'success';


    }
};

const convertValToDate = (val) => {
    const tmp = `${String(val).substring(0, 4)}-${String(val).substring(4, 6)}-${String(val).substring(6, 8)}`
    return new Date(tmp)
}

const convertDateToVal = (val) => {
    return dayjs(val).format('YYYYMMDD')
}


const statusBodyTemplate = (rowData) => {
    const getVal = (val) => {
        if (val === true) return 'On';
        if (val === false) return 'Off';
        if (val === 'On') return 'On';
        if (val === 'Off') return 'Off'; else return 'Empty'

    }
    return <Tag value={getVal(rowData._sold_out)} severity={getSeverity(rowData._sold_out)} />;
};

const tbaBodyTemplate = (rowData) => {
    const getVal = (val) => {
        if (val === true) return 'On';
        if (val === false) return 'Off';
        if (val === 'On') return 'On';
        if (val === 'Off') return 'Off'; else return 'Empty'

    }
    return <Tag value={getVal(rowData.tba)} severity={getSeverity(rowData.tba)} />;
};

const dateBodyTemplate = (rowData) => {

    return dayjs(convertValToDate(rowData.start_date)).format('MM/DD/YYYY');
};

const textEditor = (options) => {
    return <InputText type="text" value={options.value} onChange={(e) => options.editorCallback(e.target.value)} style={{ width: '100px' }} />;
};

const statusEditor = (options) => {
    return (
        <Dropdown
            value={options.value}
            options={['On', 'Off']}
            onChange={(e) => options.editorCallback(e.value)}
            placeholder="Select a Slot Status"
            itemTemplate={(option) => {
                return <Tag value={option} severity={getSeverity(option)}></Tag>;
            }}
        />
    );
};

const dateEditor = (options) => {


    const [dateVal, setDateVal] = useState(convertValToDate(options.value))

    const handleOnChange = (e) => {

        options.editorCallback(convertDateToVal(e.value))
    }

    useEffect(() => { console.log(dateVal) }, [dateVal])

    return (
        <Calendar value={dateVal} onChange={(e) => handleOnChange(e)} placeholder='Pick a date' />
        // <Dropdown
        //     value={options.value}
        //     options={['On', 'Off']}
        //     onChange={(e) => options.editorCallback(e.value)}
        //     placeholder="Select a Slot Status"
        //     itemTemplate={(option) => {
        //         return <Tag value={option} severity={getSeverity(option)}></Tag>;
        //     }}
        // />
    );
};

const tbaEditor = (options) => {
    return (
        <Dropdown
            value={options.value}
            options={['On', 'Off']}
            onChange={(e) => options.editorCallback(e.value)}
            placeholder="Select TBA"
            itemTemplate={(option) => {
                return <Tag value={option} severity={getSeverity(option)}></Tag>;
            }}
        />
    );
};






export default function Admin() {
    const { data: products } = useQuery({
        queryKey: ['slots'],
        queryFn: () => fetch('https://sundaratravelclub.com/wp-json/sundara/v1/slots').then((res) => res.json())
    })

    const qc = useQueryClient()

    const toast = useRef(null);

    useEffect(() => {
        console.log({ products })
    }, [products])


    const showSuccess = () => {
        toast.current.show({ severity: 'success', summary: 'Success', detail: 'Update Content', life: 3000 });
    }

    const showError = () => {
        toast.current.show({ severity: 'error', summary: 'Error', detail: 'on update Content', life: 3000 });
    }


    const allowEdit = (rowData) => {
        return true;
    };

    const onRowEditComplete = (e) => {
        // let _products = [...products];
        // let { newData, index } = e;

        // _products[index] = newData;

        // setProducts(_products);
        console.log({ e: e.newData })

        fetch('https://sundaratravelclub.com/wp-json/sundara/v1/slots', {
            method: 'POST',
            body: JSON.stringify({
                _sold_out: e.newData._sold_out,
                _slot_count: e.newData._slot_count,
                post_id: e.newData.ID,
                start_date: e.newData.start_date,
                tba: e.newData.tba
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        }).then((res) => res.json()).then((res) => {
            showSuccess()
            qc.invalidateQueries({
                queryKey: ['slots']
            })
        }).catch((err) => {
            console.log(err)
            showError()
        })
    };



    return (
        <div className="card" style={{ 'min-width': '98%' }}>
            <Toast ref={toast} />
            <DataTable editMode="row" onRowEditComplete={onRowEditComplete} dataKey="ID" value={products} stripedRows tableStyle={{ minWidth: '50rem' }} paginator rows={50} rowsPerPageOptions={[5, 10, 25, 50]} >
                <Column field="ID" sortable header="Product ID"></Column>
                <Column field="post_title" sortable header="Title"></Column>
                <Column field="start_date" sortable body={dateBodyTemplate} editor={(options) => dateEditor(options)} style={{ width: '20%' }} header="Start Date"></Column>
                <Column field="tba" body={tbaBodyTemplate} editor={(options) => tbaEditor(options)} style={{ width: '20%' }} header="TBA"></Column>
                <Column field="_sold_out" body={statusBodyTemplate} editor={(options) => statusEditor(options)} header="Sold Out" style={{ width: '20%' }}></Column>
                <Column field="_slot_count" header="Slots Count" editor={(options) => textEditor(options)} style={{ width: '10%' }}></Column>
                <Column header="Action" rowEditor={allowEdit} headerStyle={{ width: '10%', minWidth: '8rem' }} bodyStyle={{ textAlign: 'center' }} style={{ width: '20%' }}></Column>

            </DataTable>
        </div>
    )
}