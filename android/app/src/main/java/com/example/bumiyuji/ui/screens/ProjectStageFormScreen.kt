package com.example.bumiyuji.ui.screens

import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Modifier
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import com.example.bumiyuji.ui.UiState
import com.example.bumiyuji.ui.components.BumiyujiButton
import com.example.bumiyuji.ui.components.BumiyujiTextField
import com.example.bumiyuji.ui.components.BumiyujiTopBar
import com.example.bumiyuji.ui.theme.WarmCream
import com.example.bumiyuji.ui.viewmodel.ProjectViewModel

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ProjectStageFormScreen(
    viewModel: ProjectViewModel,
    projectId: Int,
    stageId: Int? = null,
    onNavigateBack: () -> Unit
) {
    var name by remember { mutableStateOf("") }
    var status by remember { mutableStateOf("pending") }
    var sortOrder by remember { mutableStateOf("0") }
    var startDate by remember { mutableStateOf("") }
    var endDate by remember { mutableStateOf("") }
    var description by remember { mutableStateOf("") }

    LaunchedEffect(projectId) {
        viewModel.fetchDetail(projectId)
    }

    val detailState = viewModel.detailUiState
    LaunchedEffect(detailState) {
        if (stageId != null && detailState is UiState.Success) {
            val stage = detailState.data.stages?.find { it.id == stageId }
            if (stage != null) {
                name = stage.name
                status = stage.status
                sortOrder = stage.sort_order.toString()
                startDate = stage.start_date ?: ""
                endDate = stage.end_date ?: ""
                description = stage.description ?: ""
            }
        }
    }

    Scaffold(
        topBar = {
            BumiyujiTopBar(
                title = if (stageId == null) "Tambah Tahapan" else "Edit Tahapan",
                onBackClick = onNavigateBack
            )
        },
        containerColor = WarmCream
    ) { innerPadding ->
        Column(
            modifier = Modifier
                .padding(innerPadding)
                .fillMaxSize()
                .padding(24.dp)
                .verticalScroll(rememberScrollState()),
            verticalArrangement = Arrangement.spacedBy(20.dp)
        ) {
            BumiyujiTextField(value = name, onValueChange = { name = it }, label = "Nama Tahapan *")
            BumiyujiTextField(value = status, onValueChange = { status = it }, label = "Status (e.g. pending, selesai)")
            BumiyujiTextField(value = sortOrder, onValueChange = { sortOrder = it }, label = "Urutan (Angka)")

            Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                BumiyujiTextField(value = startDate, onValueChange = { startDate = it }, label = "Mulai", modifier = Modifier.weight(1f))
                BumiyujiTextField(value = endDate, onValueChange = { endDate = it }, label = "Selesai", modifier = Modifier.weight(1f))
            }

            BumiyujiTextField(value = description, onValueChange = { description = it }, label = "Deskripsi", singleLine = false, modifier = Modifier.heightIn(min = 100.dp))

            BumiyujiButton(
                text = "Simpan Tahapan",
                onClick = {
                    val data = mutableMapOf<String, String>()
                    data["name"] = name
                    data["status"] = status
                    data["sort_order"] = sortOrder
                    data["start_date"] = startDate
                    data["end_date"] = endDate
                    data["description"] = description

                    if (stageId == null) {
                        viewModel.createStage(projectId, data)
                    } else {
                        viewModel.updateStage(projectId, stageId, data)
                    }
                    onNavigateBack()
                },
                isLoading = detailState is UiState.Loading
            )
        }
    }
}
