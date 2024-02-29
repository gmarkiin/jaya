import { FormControl, MenuItem, InputLabel } from '@mui/material'
import Select, { SelectChangeEvent } from '@mui/material/Select';
import React, { useEffect, useState } from 'react';
import { fetchInstallmentsOptions } from '../services/getInstallments';

export const InstallmentsField = () => {
    const [installmentsOptions, setInstallmentsOptions] = useState<string[]>([]);

    useEffect(() => {
        fetchInstallmentsOptions().then(installmentsOptions => {
            setInstallmentsOptions(installmentsOptions);
        });
    }, []);

    const [installment, setInstallment] = React.useState('');
    const handleChange = (event: SelectChangeEvent) => {
        setInstallment(event.target.value);
    };

    return (
        <FormControl sx={{ minWidth: 370 }} size="small">
            <InputLabel id="demo-simple-select-label" sx={{ marginTop: 2, }}>Selecione o numero de parcelas</InputLabel>
            <Select
                sx={{ marginTop: 3 }}
                labelId="demo-select-small-label"
                id="demo-select-small"
                value={installment}
                onChange={handleChange}
            >
                {installmentsOptions.map((option, index) => (
                    <MenuItem key={index} value={option}>{option}</MenuItem>
                ))}
            </Select>
        </FormControl>
    )
}