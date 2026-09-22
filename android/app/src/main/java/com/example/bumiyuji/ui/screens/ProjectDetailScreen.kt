package com.example.bumiyuji.ui.screens

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.ArrowBack
import androidx.compose.material.icons.filled.Add
import androidx.compose.material.icons.filled.Check
import androidx.compose.material.icons.filled.Delete
import androidx.compose.material.icons.filled.Edit
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import coil.compose.AsyncImage
import com.example.bumiyuji.ui.UiState
import com.example.bumiyuji.ui.components.BumiyujiLoading
import com.example.bumiyuji.ui.theme.DarkCharcoal
import com.example.bumiyuji.ui.theme.GoldAccent
import com.example.bumiyuji.ui.theme.WarmCream
import com.example.bumiyuji.ui.viewmodel.ProjectViewModel
import com.example.bumiyuji.util.ImageUtils

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ProjectDetailScreen(
    viewModel: ProjectViewModel,
    projectId: Int,
    onNavigateBack: () -> Unit,
    onNavigateToEdit: (Int) -> Unit,
    onNavigateToAddStage: (Int) -> Unit,
    onNavigateToEditStage: (Int, Int) -> Unit
) {
    var showDeleteDialog by remember { mutableStateOf(false) }
    var stageToDelete by remember { mutableStateOf<com.example.bumiyuji.data.api.ProjectStageDto?>(null) }

    LaunchedEffect(projectId) {
        viewModel.fetchDetail(projectId)
    }

    val uiState = viewModel.detailUiState

    if (showDeleteDialog) {
        AlertDialog(
            onDismissRequest = { showDeleteDialog = false },
            title = { Text("Hapus Project?") },
            text = { Text("Project dan seluruh tahapan terkait akan dihapus secara permanen.") },
            confirmButton = {
                TextButton(onClick = {
                    viewModel.deleteProject(projectId)
                    showDeleteDialog = false
                    onNavigateBack()
                }) {
                    Text("Hapus", color = MaterialTheme.colorScheme.error)
                }
            },
            dismissButton = {
                TextButton(onClick = { showDeleteDialog = false }) {
                    Text("Batal")
                }
            }
        )
    }

    if (stageToDelete != null) {
        AlertDialog(
            onDismissRequest = { stageToDelete = null },
            title = { Text("Hapus Tahapan?") },
            text = { Text("Apakah Anda yakin ingin menghapus tahapan '${stageToDelete?.name}'?") },
            confirmButton = {
                TextButton(onClick = {
                    stageToDelete?.let { viewModel.deleteStage(projectId, it.id) }
                    stageToDelete = null
                }) {
                    Text("Hapus", color = MaterialTheme.colorScheme.error)
                }
            },
            dismissButton = {
                TextButton(onClick = { stageToDelete = null }) {
                    Text("Batal")
                }
            }
        )
    }

    Scaffold(
        containerColor = WarmCream,
        floatingActionButton = {
            if (uiState is UiState.Success) {
                Column(verticalArrangement = Arrangement.spacedBy(12.dp)) {
                    SmallFloatingActionButton(onClick = { onNavigateToEdit(projectId) }) {
                        Icon(Icons.Default.Edit, contentDescription = "Edit")
                    }
                    FloatingActionButton(
                        onClick = { showDeleteDialog = true },
                        containerColor = MaterialTheme.colorScheme.error
                    ) {
                        Icon(Icons.Default.Delete, contentDescription = "Delete", tint = Color.White)
                    }
                }
            }
        }
    ) { innerPadding ->
        Box(modifier = Modifier.padding(innerPadding).fillMaxSize()) {
            when (uiState) {
                is UiState.Loading -> BumiyujiLoading()
                is UiState.Error -> {
                    Column(modifier = Modifier.align(Alignment.Center), horizontalAlignment = Alignment.CenterHorizontally) {
                        Text(text = uiState.message)
                        Button(onClick = { viewModel.fetchDetail(projectId) }) { Text("Coba Lagi") }
                    }
                }
                is UiState.Success -> {
                    val project = uiState.data
                    Column(
                        modifier = Modifier
                            .fillMaxSize()
                            .verticalScroll(rememberScrollState())
                    ) {
                        Box {
                            AsyncImage(
                                model = ImageUtils.resolveImageUrl(project.cover_image),
                                contentDescription = null,
                                modifier = Modifier
                                    .fillMaxWidth()
                                    .height(250.dp),
                                contentScale = ContentScale.Crop
                            )
                            IconButton(
                                onClick = onNavigateBack,
                                modifier = Modifier.padding(16.dp).background(Color.Black.copy(alpha = 0.3f), RoundedCornerShape(12.dp))
                            ) {
                                Icon(Icons.AutoMirrored.Filled.ArrowBack, contentDescription = "Back", tint = Color.White)
                            }
                        }

                        Column(modifier = Modifier.padding(24.dp)) {
                            Row(verticalAlignment = Alignment.CenterVertically) {
                                StatusBadge(status = project.status)
                                Spacer(modifier = Modifier.width(12.dp))
                                Text(text = project.category ?: "Uncategorized", color = Color.Gray, style = MaterialTheme.typography.bodySmall)
                            }

                            Spacer(modifier = Modifier.height(16.dp))

                            Text(
                                text = project.name,
                                style = MaterialTheme.typography.headlineMedium,
                                fontWeight = FontWeight.Bold,
                                color = DarkCharcoal
                            )
                            Text(
                                text = project.client,
                                style = MaterialTheme.typography.titleMedium,
                                color = Color.Gray
                            )

                            Spacer(modifier = Modifier.height(24.dp))

                            InfoRow(label = "Lokasi", value = project.location ?: "N/A")
                            InfoRow(label = "Timeline", value = "${project.start_date ?: "N/A"} — ${project.deadline ?: "N/A"}")

                            Spacer(modifier = Modifier.height(32.dp))

                            Text(text = "Project Progress", style = MaterialTheme.typography.titleMedium, fontWeight = FontWeight.Bold)
                            Spacer(modifier = Modifier.height(8.dp))
                            Row(verticalAlignment = Alignment.CenterVertically) {
                                LinearProgressIndicator(
                                    progress = { project.progress / 100f },
                                    modifier = Modifier.weight(1f).height(12.dp).clip(RoundedCornerShape(6.dp)),
                                    color = GoldAccent,
                                    trackColor = Color.LightGray.copy(alpha = 0.3f)
                                )
                                Spacer(modifier = Modifier.width(12.dp))
                                Text(text = "${project.progress}%", fontWeight = FontWeight.Bold)
                            }

                            Spacer(modifier = Modifier.height(32.dp))

                            Text(text = "Deskripsi", style = MaterialTheme.typography.titleMedium, fontWeight = FontWeight.Bold)
                            Spacer(modifier = Modifier.height(8.dp))
                            Text(text = project.description ?: "Tidak ada deskripsi", style = MaterialTheme.typography.bodyLarge, color = Color.DarkGray)

                            // Stages
                            Spacer(modifier = Modifier.height(40.dp))
                            Row(verticalAlignment = Alignment.CenterVertically) {
                                Text(text = "Tahapan Proyek", style = MaterialTheme.typography.titleLarge, fontWeight = FontWeight.Bold)
                                Spacer(modifier = Modifier.weight(1f))
                                TextButton(onClick = { onNavigateToAddStage(projectId) }) {
                                    Icon(Icons.Default.Add, contentDescription = null, modifier = Modifier.size(16.dp))
                                    Spacer(modifier = Modifier.width(4.dp))
                                    Text("Tambah")
                                }
                            }
                            Spacer(modifier = Modifier.height(16.dp))

                            if (project.stages.isNullOrEmpty()) {
                                Text(text = "Belum ada tahapan", color = Color.Gray)
                            } else {
                                project.stages.forEach { stage ->
                                    ProjectStageItem(
                                        stage = stage,
                                        onEdit = { onNavigateToEditStage(projectId, stage.id) },
                                        onDelete = { stageToDelete = stage }
                                    )
                                }
                            }
                        }
                    }
                }
                else -> {}
            }
        }
    }
}

@Composable
fun InfoRow(label: String, value: String) {
    Row(modifier = Modifier.padding(vertical = 4.dp)) {
        Text(text = "$label: ", style = MaterialTheme.typography.bodyMedium, color = Color.Gray)
        Text(text = value, style = MaterialTheme.typography.bodyMedium, fontWeight = FontWeight.Medium)
    }
}

@Composable
fun ProjectStageItem(
    stage: com.example.bumiyuji.data.api.ProjectStageDto,
    onEdit: () -> Unit,
    onDelete: () -> Unit
) {
    val isCompleted = stage.status.lowercase() == "selesai"
    Row(modifier = Modifier.padding(vertical = 12.dp)) {
        Column(horizontalAlignment = Alignment.CenterHorizontally) {
            Surface(
                modifier = Modifier.size(32.dp),
                shape = androidx.compose.foundation.shape.CircleShape,
                color = if (isCompleted) GoldAccent else Color.LightGray.copy(alpha = 0.5f)
            ) {
                Box(contentAlignment = Alignment.Center) {
                    if (isCompleted) {
                        Icon(imageVector = Icons.Default.Check, contentDescription = null, tint = Color.White, modifier = Modifier.size(16.dp))
                    }
                }
            }
            Box(modifier = Modifier.width(2.dp).height(40.dp).background(Color.LightGray.copy(alpha = 0.5f)))
        }

        Spacer(modifier = Modifier.width(16.dp))

        Column(modifier = Modifier.weight(1f)) {
            Text(text = stage.name, style = MaterialTheme.typography.titleSmall, fontWeight = FontWeight.Bold)
            Text(text = stage.status.uppercase(), style = MaterialTheme.typography.labelSmall, color = if (isCompleted) GoldAccent else Color.Gray)
            if (!stage.description.isNullOrEmpty()) {
                Spacer(modifier = Modifier.height(4.dp))
                Text(text = stage.description, style = MaterialTheme.typography.bodySmall, color = Color.Gray)
            }
        }

        IconButton(onClick = onEdit) {
            Icon(Icons.Default.Edit, contentDescription = "Edit", modifier = Modifier.size(18.dp), tint = Color.Gray)
        }
        IconButton(onClick = onDelete) {
            Icon(Icons.Default.Delete, contentDescription = "Delete", modifier = Modifier.size(18.dp), tint = MaterialTheme.colorScheme.error.copy(alpha = 0.5f))
        }
    }
}
