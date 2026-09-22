package com.example.bumiyuji.ui.screens

import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.Logout
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.vector.ImageVector
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import com.example.bumiyuji.ui.components.BumiyujiCard
import com.example.bumiyuji.ui.theme.DarkCharcoal
import com.example.bumiyuji.ui.theme.GoldAccent
import com.example.bumiyuji.ui.theme.WarmCream
import com.example.bumiyuji.ui.viewmodel.PortfolioViewModel
import com.example.bumiyuji.ui.viewmodel.ProjectViewModel

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun DashboardScreen(
    portfolioViewModel: PortfolioViewModel,
    projectViewModel: ProjectViewModel,
    onNavigateToPortfolios: () -> Unit,
    onNavigateToProjects: () -> Unit,
    onNavigateToHero: () -> Unit,
    onNavigateToServices: () -> Unit,
    onNavigateToTeam: () -> Unit,
    onNavigateToSettings: () -> Unit,
    onLogout: () -> Unit
) {
    LaunchedEffect(Unit) {
        portfolioViewModel.fetchPortfolios()
        projectViewModel.fetchProjects()
    }

    val portfolioCount = when (val state = portfolioViewModel.portfoliosUiState) {
        is com.example.bumiyuji.ui.UiState.Success -> state.data.size.toString()
        else -> "-"
    }

    val projectCount = when (val state = projectViewModel.projectsUiState) {
        is com.example.bumiyuji.ui.UiState.Success -> state.data.size.toString()
        else -> "-"
    }

    Scaffold(
        topBar = {
            CenterAlignedTopAppBar(
                title = {
                    Text(
                        "Bumiyuji Admin",
                        style = MaterialTheme.typography.titleLarge,
                        fontWeight = FontWeight.Bold
                    )
                },
                actions = {
                    IconButton(onClick = onLogout) {
                        Icon(Icons.AutoMirrored.Filled.Logout, contentDescription = "Logout", tint = MaterialTheme.colorScheme.error)
                    }
                },
                colors = TopAppBarDefaults.centerAlignedTopAppBarColors(
                    containerColor = Color.Transparent,
                    titleContentColor = DarkCharcoal,
                    actionIconContentColor = DarkCharcoal
                )
            )
        },
        containerColor = WarmCream
    ) { innerPadding ->
        LazyColumn(
            modifier = Modifier
                .padding(innerPadding)
                .fillMaxSize()
                .padding(horizontal = 20.dp),
            verticalArrangement = Arrangement.spacedBy(24.dp)
        ) {
            item {
                HeaderSection()
            }

            item {
                Row(
                    modifier = Modifier.fillMaxWidth(),
                    horizontalArrangement = Arrangement.spacedBy(12.dp)
                ) {
                    StatCard(
                        title = "Portfolio",
                        value = portfolioCount,
                        icon = Icons.Default.Work,
                        modifier = Modifier.weight(1f),
                        containerColor = GoldAccent
                    )
                    StatCard(
                        title = "Project",
                        value = projectCount,
                        icon = Icons.Default.Engineering,
                        modifier = Modifier.weight(1f),
                        containerColor = DarkCharcoal,
                        contentColor = Color.White
                    )
                }
            }

            item {
                Text(
                    text = "Kelola Konten",
                    style = MaterialTheme.typography.titleMedium,
                    fontWeight = FontWeight.Bold,
                    color = DarkCharcoal
                )
            }

            item {
                ModuleGrid(
                    onNavigateToPortfolios,
                    onNavigateToProjects,
                    onNavigateToHero,
                    onNavigateToServices,
                    onNavigateToTeam,
                    onNavigateToSettings
                )
            }

            item {
                Spacer(modifier = Modifier.height(20.dp))
            }
        }
    }
}

@Composable
fun HeaderSection() {
    Column {
        Text(
            text = "Selamat datang kembali,",
            style = MaterialTheme.typography.bodyLarge,
            color = Color.Gray
        )
        Text(
            text = "Admin Bumiyuji",
            style = MaterialTheme.typography.headlineMedium,
            fontWeight = FontWeight.Bold,
            color = DarkCharcoal
        )
    }
}

@Composable
fun StatCard(
    title: String,
    value: String,
    icon: ImageVector,
    modifier: Modifier = Modifier,
    containerColor: Color = Color.White,
    contentColor: Color = DarkCharcoal
) {
    Surface(
        modifier = modifier.height(100.dp),
        shape = RoundedCornerShape(20.dp),
        color = containerColor,
        shadowElevation = 2.dp
    ) {
        Box(modifier = Modifier.padding(16.dp)) {
            Column(modifier = Modifier.align(Alignment.BottomStart)) {
                Text(text = value, style = MaterialTheme.typography.headlineMedium, fontWeight = FontWeight.Bold, color = contentColor)
                Text(text = title, style = MaterialTheme.typography.labelMedium, color = contentColor.copy(alpha = 0.7f))
            }
            Icon(
                imageVector = icon,
                contentDescription = null,
                modifier = Modifier.align(Alignment.TopEnd).size(24.dp),
                tint = contentColor.copy(alpha = 0.5f)
            )
        }
    }
}

@Composable
fun ModuleGrid(
    onPortfolios: () -> Unit,
    onProjects: () -> Unit,
    onHero: () -> Unit,
    onServices: () -> Unit,
    onTeam: () -> Unit,
    onSettings: () -> Unit
) {
    Column(verticalArrangement = Arrangement.spacedBy(12.dp)) {
        ModuleItem("Hero Slides", "Banner utama website", Icons.Default.Image, onHero)
        ModuleItem("Portfolio", "Proyek desain & interior", Icons.Default.Folder, onPortfolios)
        ModuleItem("Projects", "Manajemen proyek aktif", Icons.Default.Engineering, onProjects)
        ModuleItem("Services", "Daftar layanan perusahaan", Icons.Default.Handyman, onServices)
        ModuleItem("Team", "Anggota tim Bumiyuji", Icons.Default.People, onTeam)
        ModuleItem("Settings", "Informasi & kontak website", Icons.Default.Settings, onSettings)
    }
}

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ModuleItem(
    title: String,
    description: String,
    icon: ImageVector,
    onClick: () -> Unit
) {
    BumiyujiCard(
        onClick = onClick,
        modifier = Modifier.fillMaxWidth()
    ) {
        Row(
            modifier = Modifier.padding(20.dp),
            verticalAlignment = Alignment.CenterVertically
        ) {
            Surface(
                modifier = Modifier.size(48.dp),
                shape = RoundedCornerShape(12.dp),
                color = WarmCream
            ) {
                Box(contentAlignment = Alignment.Center) {
                    Icon(imageVector = icon, contentDescription = null, tint = GoldAccent)
                }
            }

            Spacer(modifier = Modifier.width(16.dp))

            Column(modifier = Modifier.weight(1f)) {
                Text(text = title, style = MaterialTheme.typography.titleMedium, fontWeight = FontWeight.Bold)
                Text(text = description, style = MaterialTheme.typography.bodySmall, color = Color.Gray)
            }

            Icon(
                imageVector = Icons.Default.ChevronRight,
                contentDescription = null,
                tint = Color.LightGray
            )
        }
    }
}
