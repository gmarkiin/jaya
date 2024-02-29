import { Stack, TextField } from '@mui/material'

export const CardNumberField = () => {
    return (
        <Stack sx={{marginTop: 2}}>
            <Stack direction={'row'} spacing={202}>
                <TextField label='Nome do titular' />
            </Stack>
        </Stack>
    )
}