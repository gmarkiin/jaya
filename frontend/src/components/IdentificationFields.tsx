import { FormControl, TextField, MenuItem } from '@mui/material'
import Select, { SelectChangeEvent } from '@mui/material/Select';
import * as React from 'react';

export const IdentificationFields = () => {
    const [age, setAge] = React.useState('');

    const handleChange = (event: SelectChangeEvent) => {
        setAge(event.target.value);
    };
    return (
        <FormControl sx={{ m: 0, minWidth: 370 }} size="small">
            <Select  
                sx={{marginTop: 3}}
                labelId="demo-select-small-label"
                id="demo-select-small"
                defaultValue='cpf'
                value={age}
                onChange={handleChange}
            >
                <MenuItem value={'cpf'}>CPF</MenuItem>
                <MenuItem value={'cnpj'}>CNPJ</MenuItem>
            </Select>
            <TextField sx={{marginTop: 3}} label='Numero de identificacao' />
        </FormControl>
    )
}