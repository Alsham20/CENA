import { faker } from '@faker-js/faker'
import { ref } from 'vue'

export const articles = [
  {
    id: faker.string.uuid(),
    title: 'Briefing des équipes de la CENA dans le cadre de la mission de recrutement des Membres de Postes de Vote.',
    imageUrl: '/assets/img/news/news_2.jpg',
    date: '2025-09-04 21:52:44',
  },
  {
    id: faker.string.uuid(),
    title: 'Présidentielle 2026 : la CENA lance la délivrance des formulaires de parrainage',
    imageUrl: '/assets/img/news/news_3.jpg',
    date: '2025-09-02 10:53:46',
  },
  {
    id: faker.string.uuid(),
    title: 'La Cena échange avec les partis politiques sur le suivi du code électoral et la plateforme e-Delegue',
    imageUrl: '/assets/img/news/news_1.jpg',
    date: '2025-08-28 14:16:02',
  }
]

export const videos = Array.from({ length: 200 }, () => ({
  id: faker.lorem.lines(3),
  title: faker.helpers.arrayElement([
    'RÉCEPTION DE LA LEI PAR LA CENA: SACCA LAFIA FIER DE L\'ABOUTISSEMENT HEUREUX',
    'MESSAGE DU PRÉSIDENT DE LA CENA SACCA LAFIA SUR LE LANCEMENT DU SCRUTIN DU 8 JANVIER 2023',
    'REUNION CRUCIALE ENTRE LA CENA ET LA HAAC'
  ]),
  youtubeId: faker.helpers.arrayElement([
    'rCuVW7py4YU',
    'ifTICSDU2q8',
    'OJiDjW55T-o',
  ]),
  date: faker.date.past(),
  category: faker.helpers.arrayElement([
    'Réunion',
    'Actualité',
    'Scrutin',
    'Événement',
  ]),
  activity: faker.helpers.arrayElement([
    'Projets',
    'Audiences',
    'Tutoriels',
  ]),
}))

export const services = [
  {
    id: 1,
    title: 'COUR CONSTITUTIONNELLE',
    description: 'Elle est l\'organe régulateur du fonctionnement des institutions et de l\'activité des pouvoirs publics',
    backgroundImage: '/assets/img/services/cour-constitutionnelle-removebg-preview.png',
    overlayColor: '#1e3a8a', // Bleu foncé
    logo: '/assets/img/services/cour-constitutionnelle-removebg-preview.png',
    link: 'https://courconstitutionnelle.bj/'
  },
  {
    id: 2,
    title: 'COUR SUPRÊME',
    description: 'C\'est la plus haute juridiction de l\'État en matière administrative, judiciaire et des comptes de l\'État',
    backgroundImage: '/assets/img/services/coursupreme.png',
    overlayColor: '#991b1b', // Rouge foncé
    logo: '/assets/img/services/coursupreme-removebg-preview.png',
    link: 'https://www.coursupreme.bj/'
  },
  {
    id: 3,
    title: 'ANIP',
    description: 'L\'ANIP assure la modernisation du processus d\'identification des personnes sur le territoire national',
    backgroundImage: '/assets/img/services/ANIP.jpeg',
    overlayColor: '#065f46', // Vert foncé
    logo: '/assets/img/services/ANIP-removebg-preview.png',
    link: 'https://www.anip.bj/'
  },
  {
    id: 4,
    title: 'Partis Politiques',
    description: 'Portail de l\ensemble des partis politiques du Bénin',
    backgroundImage: '/assets/img/services/portail_des_partis_politiques.png',
    overlayColor: '#92400e', // Orange foncé
    logo: '/assets/img/services/portail_des_partis_politiques-removebg.png',
    link: 'https://portailpartispolitiques.bj/'
  }
]

export const resources = Array.from({ length: 200 }, () => ({
  id: faker.string.uuid(),
  title: faker.lorem.sentence(),
  size: faker.number.int({ min: 15, max: 5000 }),
  type: faker.helpers.arrayElement([
    'Cadre légal',
    'Décisions',
    'Communiqués de presse',
    'Rapports',
    'Discours',
  ]),
  publishedAt: faker.date.past(),
}))

export const decisions = [
  {
    id: '1',
    number: 'DCC25-234',
    date: new Date('2025-07-24'),
    object: 'Recours pour inconstitutionnalité de leur détention provisoire'
  },
  {
    id: '2',
    number: 'DCC25-233',
    date: new Date('2025-07-24'),
    object: 'Recours pour détention arbitraire, fausse accusation et sollicitent leur mise en liberté d\'office'
  },
  {
    id: '3',
    number: 'DCC25-231',
    date: new Date('2025-07-24'),
    object: 'Recours pour solliciter l\'intervention de la Cour dans une procédure judiciaire'
  },
  {
    id: '4',
    number: 'DCC25-230',
    date: new Date('2025-07-23'),
    object: 'Demande d\'interprétation de l\'article 15 de la Constitution'
  },
  {
    id: '5',
    number: 'DCC25-229',
    date: new Date('2025-07-23'),
    object: 'Recours en annulation d\'un acte administratif'
  },
  {
    id: '6',
    number: 'DCC25-228',
    date: new Date('2025-07-22'),
    object: 'Contrôle de constitutionnalité d\'une loi organique'
  },
  {
    id: '7',
    number: 'DCC25-227',
    date: new Date('2025-07-22'),
    object: 'Recours pour violation des droits fondamentaux'
  },
  {
    id: '8',
    number: 'DCC25-226',
    date: new Date('2025-07-21'),
    object: 'Demande d\'avis consultatif sur une disposition légale'
  },
  {
    id: '9',
    number: 'DCC25-225',
    date: new Date('2025-07-21'),
    object: 'Recours en révision d\'une décision antérieure'
  },
  {
    id: '10',
    number: 'DCC25-224',
    date: new Date('2025-07-20'),
    object: 'Contrôle de conformité constitutionnelle d\'un traité international'
  }
]

export const events = [
  {
    id: 1,
    title: "Visite à la GDIZ : La CENA enthousiaste, explore des pistes de partenariat avec la SIPI-Bénin",
    description: "Une forte délégation de la Commission Électorale Nationale Autonome (CENA) s'est rendue ce mercredi 9 juillet 2025 à la Zone industrielle de Glo-Djigbé (GDIZ). L'objectif était de constater de visu les réalisations de la Zone et d'explorer les possibilités de partenariat avec la Société d'Investissement et de Promotion de l'Industrie du Bénin (SIPI-Bénin).",
    date: "2025-07-11",
    location: "Abomey-calavie",
    category: "Industrie",
    imageUrl: "/assets/img/events/event_1.jpg",
    categoryColor: "bg-[#EC0001]"
  },
  {
    id: 2,
    title: "Le calendrier électoral est rendu public par le Président de la CENA",
    description: "La CENA a officiellement dévoilé le chronogramme des élections générales de 2026, lors d’une cérémonie à son siège à Cotonou ce mardi 15 avril 2025.",
    date: "2025-04-15",
    location: "Cotonou",
    category: "Politique",
    imageUrl: "/assets/img/events/event_2.jpg",
    categoryColor: "bg-[#EC0001]"
  },
  {
    id: 3,
    title: "CALENDRIER DE PASSAGE DES ÉQUIPES DE LA CENA DANS LE CADRE DE LA RÉCEPTION DES DOSSIERS PHYSIQUES DE CANDIDATURES DES MEMBRES DE POSTE DE VOTE DANS LES 77 COMMUNES DU BÉNIN.",
    description: "Le dépôt de dossiers physiques ne concerne pas ceux qui se sont inscrits en ligne et ont eu leurs récépissés.",
    date: "2025-09-04",
    location: 'Cotonou',
    category: "Politique",
    imageUrl: "/assets/img/events/event_3.jpg",
    categoryColor: "bg-[#EC0001]"
  },
  {
    id: 4,
    title: "Rencontre avec les Organisations de la Société Civile,  les confessions religieuses et les médias.",
    description: "Conformément à son chronogramme,  la Commission électorale nationale autonome (CENA), a tenu le mercredi 6 août 2025 à la Salle Fleuve Jaune du Ministère des Affaires étrangères une rencontre avec les représentants des OSC, des confessions religieuses et des médias pour faire un point d’étape du processus électoral en cours.",
    date: "2025-08-07",
    location: "Cotonou",
    category: "Politique",
    imageUrl: "/assets/img/events/event_4.jpg",
    categoryColor: "bg-[#EC0001]"
  }
]

export const galleryItems = [
  {
    id: 1,
    title: 'Briefing des équipes de la CENA dans le cadre de la mission de recrutement des Membres de Postes de Vote.',
    description: '',
    imageUrl: '/assets/img/news/news_2.jpg',
    date: '2025-09-04',
  },
  {
    id: 2,
    title: 'Présidentielle 2026 : la CENA lance la délivrance des formulaires de parrainage',
    description: '',
    imageUrl: '/assets/img/news/news_3.jpg',
    date: '2025-09-02',
  },
  {
    id: 3,
    title: 'La Cena échange avec les partis politiques sur le suivi du code électoral et la plateforme e-Delegue',
    description: '',
    imageUrl: '/assets/img/news/news_1.jpg',
    date: '2025-08-28',
  },
  {
    id: 4,
    imageUrl: "/assets/img/events/event_1.jpg",
    title: "Visite à la GDIZ : La CENA enthousiaste, explore des pistes de partenariat avec la SIPI-Bénin",
    description: "Une forte délégation de la Commission Électorale Nationale Autonome (CENA) s'est rendue ce mercredi 9 juillet 2025 à la Zone industrielle de Glo-Djigbé (GDIZ). L'objectif était de constater de visu les réalisations de la Zone et d'explorer les possibilités de partenariat avec la Société d'Investissement et de Promotion de l'Industrie du Bénin (SIPI-Bénin).",
    date: "2025-07-11"
  },
  {
    id: 5,
    title: "Le calendrier électoral est rendu public par le Président de la CENA",
    description: "La CENA a officiellement dévoilé le chronogramme des élections générales de 2026, lors d’une cérémonie à son siège à Cotonou ce mardi 15 avril 2025.",
    date: "2025-04-15",
    imageUrl: "/assets/img/events/event_2.jpg",
  },
  {
    id: 6,
    title: "CALENDRIER DE PASSAGE DES ÉQUIPES DE LA CENA DANS LE CADRE DE LA RÉCEPTION DES DOSSIERS PHYSIQUES DE CANDIDATURES DES MEMBRES DE POSTE DE VOTE DANS LES 77 COMMUNES DU BÉNIN.",
    description: "Le dépôt de dossiers physiques ne concerne pas ceux qui se sont inscrits en ligne et ont eu leurs récépissés.",
    date: "2025-09-04",
    imageUrl: "/assets/img/events/event_3.jpg"
  },
  {
    id: 7,
    title: "Rencontre avec les Organisations de la Société Civile,  les confessions religieuses et les médias.",
    description: "Conformément à son chronogramme,  la Commission électorale nationale autonome (CENA), a tenu le mercredi 6 août 2025 à la Salle Fleuve Jaune du Ministère des Affaires étrangères une rencontre avec les représentants des OSC, des confessions religieuses et des médias pour faire un point d’étape du processus électoral en cours.",
    date: "2025-08-07",
    imageUrl: "/assets/img/events/event_4.jpg",
  }
]

export const members: Member[] = [
  {
    id: 1,
    firstName: "Sacca",
    lastName: "LAFIA",
    position: "Président de la CENA et du Conseil Electoral",
    avatarUrl: "/assets/img/board/membre_1.jpg",
    socialLinks: {
      facebook: "javascript:void(0)",
      twitter: "javascript:void(0)",
      linkedin: "javascript:void(0)"
    }
  },

  {
    id: 3,
    firstName: "Laurentine",
    lastName: "ADOSSOU DAVO",
    position: "Rapporteur",
    avatarUrl: "/assets/img/board/membre_3.png",
    socialLinks: {
      facebook: "javascript:void(0)",
      twitter: "javascript:void(0)",
      linkedin: "javascript:void(0)"
    }
  },
  {
    id: 2,
    firstName: "François Adébayo",
    lastName: "ABIOLA",
    position: "Membre",
    avatarUrl: "/assets/img/board/membre_2.jpg",
    socialLinks: {
      facebook: "javascript:void(0)",
      twitter: "javascript:void(0)",
      linkedin: "javascript:void(0)"
    }
  },
  {
    id: 4,
    firstName: "Sanni",
    lastName: "GOUNOU",
    position: "Membre",
    avatarUrl: "/assets/img/board/membre_4.jpg",
    socialLinks: {
      facebook: "javascript:void(0)",
      twitter: "javascript:void(0)",
      linkedin: "javascript:void(0)"
    }
  },
  {
    id: 5,
    firstName: "Izou-Dine",
    lastName: "IBRAHIM",
    position: "Membre",
    avatarUrl: "/assets/img/board/membre_5.jpg",
    socialLinks: {
      facebook: "javascript:void(0)",
      twitter: "javascript:void(0)",
      linkedin: "javascript:void(0)"
    }
  }
]
